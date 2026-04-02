# Skillzy Messaging Feature - Implementation Guide

## Overview
The messaging feature allows users to communicate directly with skill listers from the skill listing pages. Users can now send messages before, during, or after making a purchase.

## Database Changes

### Migrations Applied
1. **2026_04_02_000000_make_purchase_id_nullable_in_messages.php**
   - Made `purchase_id` nullable in the messages table
   - Allows messages to be sent without an associated purchase

2. **2026_04_02_000001_add_user_skill_id_to_messages.php**
   - Added `user_skill_id` foreign key to messages table
   - Links messages to specific skill listings

### Messages Table Structure
```
- id (bigint, primary)
- purchase_id (nullable, foreign key to purchases)
- user_skill_id (nullable, foreign key to user_skills)
- sender_id (foreign key to users)
- receiver_id (foreign key to users)
- message (text)
- is_read (tinyint, default 0)
- created_at (timestamp)
- updated_at (timestamp)
```

## Features Implemented

### 1. Message Modal Component
**File:** `resources/views/components/message-modal.blade.php`

A reusable modal component that displays:
- Message form with textarea
- Automatic recipient detection based on context
- Support for purchase-based and skill listing-based messages
- Clean UI with proper validation

**Usage:**
```blade
<!-- From skill listing (index) -->
<x-message-modal :listing="$listing" />

<!-- From skill detail page -->
<x-message-modal :listing="$listing" />

<!-- From purchase -->
<x-message-modal :purchase="$purchase" />
```

### 2. Updated Listing Views

#### Index View (Grid)
**File:** `resources/views/listings/index.blade.php`

Changes:
- Removed the link wrapper to allow interactive elements
- Added message button on each skill card
- Button only appears for non-owners who are authenticated
- Restructured card layout for better UX

**Features:**
- Display message button on each listing card
- Price and experience level visible
- Click message button to open modal
- Direct gateway to contact skill lister

#### Show View (Detail Page)
**File:** `resources/views/listings/show.blade.php`

Changes:
- Added message button in the seller info section
- Button appears between rating section and profile link
- Only visible to non-owners

### 3. Enhanced MessageController
**File:** `app/Http/Controllers/MessageController.php`

**New Features:**
- Support for both purchase-based and skill listing-based messages
- Automatic receiver detection
- Flexible message routing
- Security checks to prevent self-messaging

**Method: store()**
```php
/**
 * Handle message creation
 * Supports:
 * - Messages tied to purchases
 * - Messages tied to skill listings
 * - Direct user-to-user messages with explicit receiver_id
 */
public function store(Request $request): RedirectResponse
```

**Validation Rules:**
- `message`: required, string, 1-5000 characters
- `purchase_id`: optional, must exist if provided
- `user_skill_id`: optional, must exist if provided
- `receiver_id`: optional, must exist if provided

### 4. Model Updates

#### Message Model
**File:** `app/Models/Message.php`

**New Relationship:**
```php
public function userSkill()
{
    return $this->belongsTo(UserSkill::class);
}
```

**Fillable Attributes:**
```php
'purchase_id'
'sender_id'
'receiver_id'
'message'
'is_read'
'user_skill_id'  // NEW
```

#### UserSkill Model
**File:** `app/Models/UserSkill.php`

**New Relationship:**
```php
public function messages()
{
    return $this->hasMany(Message::class);
}
```

#### User Model
Already has relationships (no changes needed):
- `sentMessages()`
- `receivedMessages()`

## How It Works

### User Flow for Messaging from Listings

1. **From Grid View (Index)**
   - User browses skill listings
   - Sees "✉️ Message" button on each card
   - Clicks button to open message modal
   - Types message and sends
   - Message is associated with the UserSkill listing

2. **From Detail Page (Show)**
   - User clicks on a skill card to view details
   - Sees seller information on the right
   - Finds "✉️ Message" button below the rating
   - Opens modal and sends message
   - Message is associated with the UserSkill listing

3. **From Purchase (Existing Feature)**
   - User purchases a skill
   - Can message during the transaction
   - Message is associated with the Purchase record

### Message Storage Logic

When a message is sent:
1. If `purchase_id` is provided → message tied to purchase
2. If `user_skill_id` is provided → message tied to skill listing
3. If neither → message is just user-to-user

The receiver is automatically determined:
- For purchases: opposite party in the transaction
- For skill listings: the skill lister (user_id)
- For direct messages: specified receiver_id

## Testing the Feature

### Test Case 1: Message from Grid
1. Login as User A
2. Browse skill listings (not your own)
3. Click "✉️ Message" button on a card
4. Send a message
5. Check database: `messages` table should have new record with `user_skill_id` set

### Test Case 2: Message from Detail Page
1. Login as User A
2. Click on a skill listing to view details
3. In seller section, click "✉️ Message"
4. Send a message
5. Verify message appears in database

### Test Case 3: Message from Purchase
1. Purchase a skill
2. Send message through the purchase detail page
3. Verify `purchase_id` is set instead of `user_skill_id`

## API Integration Points

### Routes
```
POST /messages - Store a new message
```

### Request Payload
```json
{
    "message": "Message text here",
    "user_skill_id": 5,          // Optional: for skill listing messages
    "purchase_id": null,          // Optional: for purchase messages
    "receiver_id": null           // Optional: explicit receiver
}
```

### Response
- **Success:** Redirect back with success message
- **Error:** Redirect back with error details

## Future Enhancement Ideas

1. **Messages Page**
   - View all conversations
   - Filter by sender/receiver
   - Search messages
   - Mark as unread/read

2. **Notifications**
   - Notify users of new messages
   - Real-time updates (WebSockets)

3. **Message Threads**
   - Group messages by sender-receiver pair
   - Conversation view

4. **Message Moderation**
   - Report inappropriate messages
   - Admin dashboard for review

## Security Features

1. **Authentication**
   - All message operations require authentication
   - Middleware: `auth`

2. **Authorization**
   - Users cannot message themselves
   - Messages only between valid parties

3. **Input Validation**
   - Message length validated (1-5000 chars)
   - Foreign key validation for all references

## Troubleshooting

### Message Button Not Appearing
- Ensure user is authenticated (`@auth` check)
- Verify user is not the skill lister
- Check if `Auth::user()->id !== $listing->user_id`

### Modal Not Opening
- Check browser console for JavaScript errors
- Verify `toggleMessageModal()` function is loaded
- Ensure modal ID is unique

### Message Not Sending
- Check Laravel logs: `storage/logs/laravel.log`
- Verify form has all required fields
- Check database migrations ran successfully

### Messages with NULL Values
- Ensure either `user_skill_id` or `purchase_id` is set
- Don't send messages with both NULL

## File Summary

### New Files Created
- `database/migrations/2026_04_02_000000_make_purchase_id_nullable_in_messages.php`
- `database/migrations/2026_04_02_000001_add_user_skill_id_to_messages.php`
- `resources/views/components/message-modal.blade.php`

### Modified Files
- `app/Http/Controllers/MessageController.php`
- `app/Models/Message.php`
- `app/Models/UserSkill.php`
- `resources/views/listings/index.blade.php`
- `resources/views/listings/show.blade.php`

### Unchanged (Already Had Message Support)
- `routes/web.php`
- `app/Models/User.php`
