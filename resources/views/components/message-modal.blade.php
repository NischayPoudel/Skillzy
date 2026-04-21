@props([
    'listing' => null,
    'purchase' => null,
    'receiverId' => null,
    'receiverName' => null,
    'user' => null,
])

@php
    $authUser = Auth::user();
    
    // Check if owner
    $isOwner = false;
    if ($authUser && $listing) {
        $isOwner = $listing->user_id === $authUser->id;
    }
    
    // If 'user' prop is provided (from profile page), set receiverId
    if ($user && !$receiverId) {
        $receiverId = $user->id;
        $receiverName = $user->name;
    }
    
    // Determine if message button should be shown
    $canMessage = $authUser && !$isOwner && ($receiverId ? $authUser->id !== $receiverId : true);
    
    // Determine the receiver ID for the messages link
    $messageReceiverId = null;
    if ($listing && $listing->user_id) {
        $messageReceiverId = $listing->user_id;
    } elseif ($purchase && $purchase->seller_id) {
        $messageReceiverId = $purchase->seller_id;
    } elseif ($receiverId) {
        $messageReceiverId = $receiverId;
    }
@endphp

@if($canMessage && $messageReceiverId)
    <!-- Message Link - Redirects to Messages Page -->
    <a 
        href="{{ route('messages.show', $messageReceiverId) }}"
        style="display: block; padding: 10px 16px; background: #1040C0; color: white; border: none; border-radius: 6px; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 200ms ease-out; width: 100%; text-decoration: none; text-align: center;"
        onmouseover="this.style.background='#0D32A4'; this.style.transform='translateY(-1px)';"
        onmouseout="this.style.background='#1040C0'; this.style.transform='translateY(0)';">
        Message
    </a>
@endif
