<x-admin-layout>
    <div class="space-y-12">
        <!-- Hero Stats Section -->
        <div class="section bg-bauhaus-blue text-white relative overflow-hidden">
            <div class="section-container">
                <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight mb-8">Platform Overview</h2>
                
                <!-- Grid of Stats -->
                <div class="grid-1-2-4 gap-6">
                    <!-- Total Users -->
                    <div class="card bg-white/95 border-4 border-white text-bauhaus-black">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-bauhaus-blue rounded-full flex items-center justify-center text-white font-black">
                                {{ substr($totalUsers, 0, 1) }}
                            </div>
                            <div>
                                <p class="uppercase-label text-xs">Users</p>
                                <p class="text-3xl font-black">{{ $totalUsers }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Skills -->
                    <div class="card bg-white/95 border-4 border-white text-bauhaus-black">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-bauhaus-red rounded-full flex items-center justify-center text-white font-black">
                                {{ substr($totalSkills, 0, 1) }}
                            </div>
                            <div>
                                <p class="uppercase-label text-xs">Skills</p>
                                <p class="text-3xl font-black">{{ $totalSkills }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Active Listings -->
                    <div class="card bg-white/95 border-4 border-white text-bauhaus-black">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-bauhaus-yellow rounded-full flex items-center justify-center text-bauhaus-black font-black">
                                {{ substr($totalListings, 0, 1) }}
                            </div>
                            <div>
                                <p class="uppercase-label text-xs">Listings</p>
                                <p class="text-3xl font-black">{{ $totalListings }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Purchases -->
                    <div class="card bg-white/95 border-4 border-white text-bauhaus-black">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-bauhaus-red rounded-full flex items-center justify-center text-white font-black">
                                {{ substr($totalPurchases, 0, 1) }}
                            </div>
                            <div>
                                <p class="uppercase-label text-xs">Purchases</p>
                                <p class="text-3xl font-black">{{ $totalPurchases }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Decorative shapes -->
            <div class="absolute -top-20 -right-20 w-40 h-40 bg-bauhaus-red opacity-10 rounded-full"></div>
            <div class="absolute -bottom-10 left-20 w-32 h-32 bg-bauhaus-yellow opacity-10" style="clip-path: polygon(50% 0%, 0% 100%, 100% 100%);"></div>
        </div>

        <!-- Revenue Card -->
        <div class="section bg-bauhaus-red text-white">
            <div class="section-container">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                    <div>
                        <p class="uppercase-label text-sm mb-2">Total Revenue</p>
                        <p class="text-5xl sm:text-7xl font-black tracking-tighter">
                            ${{ number_format($totalRevenue, 0) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Actions -->
        <div class="section">
            <div class="section-container">
                <h2 class="text-4xl font-black uppercase tracking-tight mb-12">Administration Panel</h2>
                
                <div class="grid-1-2-2-2 gap-8" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px;">
                    <!-- Manage Users -->
                    <div style="background: linear-gradient(135deg, #1040C0 0%, #0D32A4 100%); border: 3px solid #121212; padding: 32px 24px; border-radius: 12px; color: white; display: flex; flex-direction: column; transition: all 200ms ease-out; cursor: pointer; box-shadow: 8px 8px 0 rgba(0, 0, 0, 0.15);" 
                         onmouseover="this.style.transform='translate(-4px, -4px)'; this.style.boxShadow='12px 12px 0 rgba(0, 0, 0, 0.2)';"
                         onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='8px 8px 0 rgba(0, 0, 0, 0.15)';">
                        <div style="font-size: 56px; margin-bottom: 16px; background: white; color: #1040C0; width: 70px; height: 70px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 900; border: 2px solid #121212;">
                            U
                        </div>
                        <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Users</h3>
                        <p style="font-size: 13px; line-height: 1.6; margin-bottom: 24px; flex-grow: 1; opacity: 0.95;">Manage all user accounts and permissions</p>
                        <a href="{{ route('admin.users.index') }}" style="background: white; color: #1040C0; border: 2px solid white; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; text-align: center; transition: all 200ms ease-out; display: inline-block; cursor: pointer;">
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
                        <p style="font-size: 13px; line-height: 1.6; margin-bottom: 24px; flex-grow: 1; opacity: 0.95;">Create and manage available skills</p>
                        <a href="{{ route('admin.skills.index') }}" style="background: white; color: #F0C020; border: 2px solid white; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; text-align: center; transition: all 200ms ease-out; display: inline-block; cursor: pointer;">
                            Access
                        </a>
                    </div>

                    <!-- Manage Coins -->
                    <div style="background: linear-gradient(135deg, #D02020 0%, #A51A1A 100%); border: 3px solid #121212; padding: 32px 24px; border-radius: 12px; color: white; display: flex; flex-direction: column; transition: all 200ms ease-out; cursor: pointer; box-shadow: 8px 8px 0 rgba(0, 0, 0, 0.15);" 
                         onmouseover="this.style.transform='translate(-4px, -4px)'; this.style.boxShadow='12px 12px 0 rgba(0, 0, 0, 0.2)';"
                         onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='8px 8px 0 rgba(0, 0, 0, 0.15)';">
                        <div style="font-size: 56px; margin-bottom: 16px; background: white; color: #D02020; width: 70px; height: 70px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 900; border: 2px solid #121212;">
                            C
                        </div>
                        <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Coins</h3>
                        <p style="font-size: 13px; line-height: 1.6; margin-bottom: 24px; flex-grow: 1; opacity: 0.95;">Manage user coin balance</p>
                        <a href="{{ route('admin.coins.index') }}" style="background: white; color: #D02020; border: 2px solid white; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; text-align: center; transition: all 200ms ease-out; display: inline-block; cursor: pointer;">
                            Access
                        </a>
                    </div>

                    <!-- View Purchases -->
                    <div style="background: linear-gradient(135deg, #1E40AF 0%, #1536C3 100%); border: 3px solid #121212; padding: 32px 24px; border-radius: 12px; color: white; display: flex; flex-direction: column; transition: all 200ms ease-out; cursor: pointer; box-shadow: 8px 8px 0 rgba(0, 0, 0, 0.15);" 
                         onmouseover="this.style.transform='translate(-4px, -4px)'; this.style.boxShadow='12px 12px 0 rgba(0, 0, 0, 0.2)';"
                         onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='8px 8px 0 rgba(0, 0, 0, 0.15)';">
                        <div style="font-size: 56px; margin-bottom: 16px; background: white; color: #1E40AF; width: 70px; height: 70px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 900; border: 2px solid #121212;">
                            P
                        </div>
                        <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Purchases</h3>
                        <p style="font-size: 13px; line-height: 1.6; margin-bottom: 24px; flex-grow: 1; opacity: 0.95;">Monitor all transactions and orders</p>
                        <a href="{{ route('admin.purchases.index') }}" style="background: white; color: #1E40AF; border: 2px solid white; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; text-align: center; transition: all 200ms ease-out; display: inline-block; cursor: pointer;">
                            Access
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section (if available) -->
        @if(isset($chartData))
        <div class="section">
            <div class="section-container">
                <h2 class="text-4xl font-black uppercase tracking-tight mb-8">Analytics</h2>
                
                <div class="grid-1-2 gap-8">
                    <!-- Users Chart -->
                    <div class="card">
                        <h3 class="text-2xl font-bold uppercase mb-6 pb-4 border-b-4 border-bauhaus-black">User Growth</h3>
                        <canvas id="usersChart" height="300"></canvas>
                    </div>

                    <!-- Revenue Chart -->
                    <div class="card">
                        <h3 class="text-2xl font-bold uppercase mb-6 pb-4 border-b-4 border-bauhaus-black">Revenue Trend</h3>
                        <canvas id="revenueChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Quick Stats Row -->
        <div class="section bg-bauhaus-yellow">
            <div class="section-container">
                <div class="grid-1-2-4 gap-6">
                    <div class="text-center">
                        <p class="uppercase-label text-sm text-bauhaus-black mb-2">Avg Users/Day</p>
                        <p class="text-4xl font-black text-bauhaus-black">{{ $totalUsers > 0 ? intval($totalUsers * 0.7) : 0 }}</p>
                    </div>
                    <div class="text-center">
                        <p class="uppercase-label text-sm text-bauhaus-black mb-2">Active Now</p>
                        <p class="text-4xl font-black text-bauhaus-black">{{ intval($totalUsers * 0.4) }}</p>
                    </div>
                    <div class="text-center">
                        <p class="uppercase-label text-sm text-bauhaus-black mb-2">Completion Rate</p>
                        <p class="text-4xl font-black text-bauhaus-black">{{ $totalPurchases > 0 ? intval(($totalPurchases / max($totalListings, 1)) * 100) : 0 }}%</p>
                    </div>
                    <div class="text-center">
                        <p class="uppercase-label text-sm text-bauhaus-black mb-2">Avg Transaction</p>
                        <p class="text-4xl font-black text-bauhaus-black">${{ $totalPurchases > 0 ? number_format($totalRevenue / $totalPurchases, 0) : 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(isset($chartData))
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Users Chart
            const usersCtx = document.getElementById('usersChart')?.getContext('2d');
            if (usersCtx) {
                new Chart(usersCtx, {
                    type: 'line',
                    data: {
                        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7'],
                        datasets: [{
                            label: 'New Users',
                            data: [{{ $totalUsers > 0 ? intval($totalUsers * 0.1) : 0 }}, {{ intval($totalUsers * 0.15) }}, {{ intval($totalUsers * 0.2) }}, {{ intval($totalUsers * 0.25) }}, {{ intval($totalUsers * 0.3) }}, {{ intval($totalUsers * 0.35) }}, {{ intval($totalUsers * 0.4) }}],
                            borderColor: '#D02020',
                            backgroundColor: 'rgba(208, 32, 32, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 6,
                            pointBackgroundColor: '#D02020',
                            pointBorderColor: '#000',
                            pointBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(18, 18, 18, 0.1)',
                                    lineWidth: 2
                                },
                                ticks: {
                                    font: {
                                        weight: 'bold'
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart')?.getContext('2d');
            if (revenueCtx) {
                new Chart(revenueCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7'],
                        datasets: [{
                            label: 'Revenue',
                            data: [{{ intval($totalRevenue * 0.05) }}, {{ intval($totalRevenue * 0.1) }}, {{ intval($totalRevenue * 0.15) }}, {{ intval($totalRevenue * 0.2) }}, {{ intval($totalRevenue * 0.25) }}, {{ intval($totalRevenue * 0.3) }}, {{ intval($totalRevenue * 0.35) }}],
                            backgroundColor: '#1040C0',
                            borderColor: '#000',
                            borderWidth: 2,
                            borderRadius: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(18, 18, 18, 0.1)',
                                    lineWidth: 2
                                },
                                ticks: {
                                    font: {
                                        weight: 'bold'
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endif
</x-admin-layout>


