<x-staff-layout>
    <div class="space-y-12">
        <!-- Hero Stats Section -->
        <div class="section bg-bauhaus-blue text-white relative overflow-hidden" style="background: #1040C0; padding: 40px; border-radius: 12px; color: white; position: relative; overflow: hidden;">
            <div class="section-container">
                <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight mb-8" style="font-size: 40px; font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 32px; margin-top: 0;">Platform Overview</h2>
                
                <!-- Grid of Stats -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px;">
                    <!-- Total Users -->
                    <div style="background: white; border: 4px solid white; padding: 24px; border-radius: 8px; color: #121212; display: flex; align-items: center; gap: 16px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
                        <div style="width: 50px; height: 50px; background-color: #1040C0; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 24px;">
                            U
                        </div>
                        <div>
                            <p style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #888; letter-spacing: 0.5px; margin: 0;">Users</p>
                            <p style="font-size: 32px; font-weight: 900; margin: 0;">{{ $totalUsers }}</p>
                        </div>
                    </div>

                    <!-- Total Skills -->
                    <div style="background: white; border: 4px solid white; padding: 24px; border-radius: 8px; color: #121212; display: flex; align-items: center; gap: 16px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
                        <div style="width: 50px; height: 50px; background-color: #F0C020; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #121212; font-weight: 900; font-size: 24px;">
                            S
                        </div>
                        <div>
                            <p style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #888; letter-spacing: 0.5px; margin: 0;">Skills</p>
                            <p style="font-size: 32px; font-weight: 900; margin: 0;">{{ $totalSkills }}</p>
                        </div>
                    </div>

                    <!-- Total Purchases -->
                    <div style="background: white; border: 4px solid white; padding: 24px; border-radius: 8px; color: #121212; display: flex; align-items: center; gap: 16px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
                        <div style="width: 50px; height: 50px; background-color: #D02020; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 24px;">
                            P
                        </div>
                        <div>
                            <p style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #888; letter-spacing: 0.5px; margin: 0;">Purchases</p>
                            <p style="font-size: 32px; font-weight: 900; margin: 0;">{{ $totalPurchases }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Decorative shapes -->
            <div style="position: absolute; top: -80px; right: -80px; width: 160px; height: 160px; background-color: #D02020; opacity: 0.08; border-radius: 50%;"></div>
            <div style="position: absolute; bottom: -40px; left: 80px; width: 128px; height: 128px; background-color: #F0C020; opacity: 0.08; clip-path: polygon(50% 0%, 0% 100%, 100% 100%);"></div>
        </div>

        <!-- Staff Administration -->
        <div style="padding: 0;">
            <h2 class="text-4xl font-black uppercase tracking-tight mb-12" style="font-size: 32px; font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 32px; margin-top: 0;">Staff Administration</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
                <!-- Manage Users -->
                <div style="background: linear-gradient(135deg, #1040C0 0%, #0D32A4 100%); border: 3px solid #121212; padding: 32px 24px; border-radius: 12px; color: white; display: flex; flex-direction: column; transition: all 200ms ease-out; cursor: pointer; box-shadow: 8px 8px 0 rgba(0, 0, 0, 0.15);" 
                     onmouseover="this.style.transform='translate(-4px, -4px)'; this.style.boxShadow='12px 12px 0 rgba(0, 0, 0, 0.2)';"
                     onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='8px 8px 0 rgba(0, 0, 0, 0.15)';">
                    <div style="font-size: 56px; margin-bottom: 16px; background: white; color: #1040C0; width: 70px; height: 70px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 900; border: 2px solid #121212;">
                        U
                    </div>
                    <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Users</h3>
                    <p style="font-size: 13px; line-height: 1.6; margin-bottom: 24px; flex-grow: 1; opacity: 0.95;">Manage user accounts and profiles</p>
                    <a href="{{ route('staff.users.index') }}" style="background: white; color: #1040C0; border: 2px solid white; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; text-align: center; transition: all 200ms ease-out; display: inline-block; cursor: pointer;">
                        Access
                    </a>
                </div>

                <!-- Manage Skills -->
                <div style="background: linear-gradient(135deg, #F0C020 0%, #D6A512 100%); border: 3px solid #121212; padding: 32px 24px; border-radius: 12px; color: #121212; display: flex; flex-direction: column; transition: all 200ms ease-out; cursor: pointer; box-shadow: 8px 8px 0 rgba(0, 0, 0, 0.15);" 
                     onmouseover="this.style.transform='translate(-4px, -4px)'; this.style.boxShadow='12px 12px 0 rgba(0, 0, 0, 0.2)';"
                     onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='8px 8px 0 rgba(0, 0, 0, 0.15)';">
                    <div style="font-size: 56px; margin-bottom: 16px; background: white; color: #F0C020; width: 70px; height: 70px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 900; border: 2px solid #121212;">
                        S
                    </div>
                    <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Skills</h3>
                    <p style="font-size: 13px; line-height: 1.6; margin-bottom: 24px; flex-grow: 1; opacity: 0.95;">Browse and manage available skills</p>
                    <a href="{{ route('staff.skills.index') }}" style="background: white; color: #F0C020; border: 2px solid white; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; text-align: center; transition: all 200ms ease-out; display: inline-block; cursor: pointer;">
                        Access
                    </a>
                </div>

                <!-- View Purchases -->
                <div style="background: linear-gradient(135deg, #D02020 0%, #A51A1A 100%); border: 3px solid #121212; padding: 32px 24px; border-radius: 12px; color: white; display: flex; flex-direction: column; transition: all 200ms ease-out; cursor: pointer; box-shadow: 8px 8px 0 rgba(0, 0, 0, 0.15);" 
                     onmouseover="this.style.transform='translate(-4px, -4px)'; this.style.boxShadow='12px 12px 0 rgba(0, 0, 0, 0.2)';"
                     onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='8px 8px 0 rgba(0, 0, 0, 0.15)';">
                    <div style="font-size: 56px; margin-bottom: 16px; background: white; color: #D02020; width: 70px; height: 70px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 900; border: 2px solid #121212;">
                        P
                    </div>
                    <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Purchases</h3>
                    <p style="font-size: 13px; line-height: 1.6; margin-bottom: 24px; flex-grow: 1; opacity: 0.95;">Monitor all transactions and orders</p>
                    <a href="{{ route('staff.purchases.index') }}" style="background: white; color: #D02020; border: 2px solid white; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; text-align: center; transition: all 200ms ease-out; display: inline-block; cursor: pointer;">
                        Access
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-staff-layout>
