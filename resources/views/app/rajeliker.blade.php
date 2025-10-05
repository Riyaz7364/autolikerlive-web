<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook Analytics Dashboard - AutoLiker Live</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            color: #4267B2;
            font-size: 2.5em;
            font-weight: 700;
            margin-bottom: 10px;
            text-align: center;
        }

        .header p {
            text-align: center;
            color: #666;
            font-size: 1.1em;
        }

        .login-section {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .facebook-login-btn {
            background: #4267B2;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .facebook-login-btn:hover {
            background: #365899;
            transform: translateY(-2px);
        }

        .dashboard {
            display: none;
        }

        .user-info {
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 4px solid #4267B2;
        }

        .user-details h2 {
            color: #4267B2;
            margin-bottom: 5px;
        }

        .user-details p {
            color: #666;
            margin: 2px 0;
        }

        .logout-btn {
            background: #e74c3c;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: auto;
        }

        .analytics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .analytics-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .analytics-card h3 {
            color: #4267B2;
            margin-bottom: 15px;
            font-size: 1.3em;
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .stat-item:last-child {
            border-bottom: none;
        }

        .stat-value {
            font-weight: bold;
            color: #4267B2;
        }

        .chart-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .loading i {
            font-size: 3em;
            margin-bottom: 15px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .refresh-btn {
            background: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        .feature-card i {
            font-size: 2.5em;
            color: #4267B2;
            margin-bottom: 15px;
        }


        .post-info {
            font-size: 16px;
            margin: 20px 0;
            line-height: 1.4;
        }

        .warning-text {
            color: #ff4444;
            font-weight: bold;
        }

        .facebook-btn {
            background-color: #4267B2;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            margin: 20px 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .facebook-btn:hover {
            background-color: #365899;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(66, 103, 178, 0.4);
        }

        .facebook-btn:active {
            transform: translateY(0);
        }

        .facebook-btn:disabled {
            background-color: #ccc !important;
            cursor: not-allowed !important;
            transform: none !important;
        }


        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 480px) {
            .login-section {
                margin: 0 15px;
                padding: 20px;
            }

            .recommendation-text {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <div class="header dashboard">
            <h1><i class="fab fa-facebook"></i> Facebook Analytics Dashboard</h1>
            <p>Professional Facebook Data Analytics & Insights Platform</p>
        </div>

        <!-- Login Section -->
        <div id="loginSection" class="login-section">
            <h2>🔐 Connect Your Facebook Account</h2>
            <p style="margin: 20px 0; color: #666;">
                Connect your Facebook account to access advanced analytics and insights about your profile, posts,
                Likes, and
                engagement metrics.
            </p>
            <div style="margin-top: 30px;">
                <button onclick="handleFacebookLogin()" class="facebook-login-btn">
                    <i class="fab fa-facebook-f"></i>
                    Login with Facebook
                </button>
            </div>

            <div style="margin-top: 10px;">
                <a href="javascript:void(0);" onclick="clearSession()">
                    Switch Account
                </a>
            </div>

            <div class="feature-grid">
                <div class="feature-card">
                    <i class="fas fa-chart-line"></i>
                    <h4>Post Analytics</h4>
                    <p>Track your post performance and engagement rates</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-users"></i>
                    <h4>Audience Insights</h4>
                    <p>Understand your audience demographics</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-heart"></i>
                    <h4>Engagement Metrics</h4>
                    <p>Monitor likes, comments, and shares</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-clock"></i>
                    <h4>Real-time Data</h4>
                    <p>Get live updates on your social media performance</p>
                </div>
            </div>


        </div>

        <!-- Dashboard Section -->
        <div id="dashboardSection" class="dashboard">
            <!-- User Info -->
            <div class="user-info">
                <img id="userAvatar" class="user-avatar" src="" alt="User Avatar">
                <div class="user-details">
                    <h2 id="userName">Loading...</h2>
                    <p id="userEmail">Email: Loading...</p>
                    <p id="loginTime">Connected: Loading...</p>
                </div>
                <button class="logout-btn" onclick="logout()">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </div>

            <!-- Analytics Grid -->
            <div class="analytics-grid">
                <!-- Profile Analytics -->
                <div class="analytics-card">
                    <h3><i class="fas fa-user"></i> Profile Information</h3>
                    <div id="profileStats">
                        <div class="loading">
                            <i class="fas fa-spinner"></i>
                            <p>Loading profile data...</p>
                        </div>
                    </div>
                </div>

                <!-- Page Insights -->
                <div class="analytics-card">
                    <h3><i class="fas fa-page4"></i> Page Management</h3>
                    <div id="pageStats">
                        <div class="loading">
                            <i class="fas fa-spinner"></i>
                            <p>Checking page access...</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="analytics-card">
                    <h3><i class="fas fa-clock"></i> App Activity</h3>
                    <div id="recentActivity">
                        <div class="loading">
                            <i class="fas fa-spinner"></i>
                            <p>Loading activity...</p>
                        </div>
                    </div>
                </div>

                <!-- Friends Analytics -->
                <div class="analytics-card">
                    <h3><i class="fas fa-users"></i> Social Data</h3>
                    <div id="friendsStats">
                        <div class="loading">
                            <i class="fas fa-spinner"></i>
                            <p>Checking permissions...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Engagement Chart -->
            <div class="chart-container">
                <h3><i class="fas fa-chart-bar"></i> Post Engagement Analytics</h3>
                <button class="refresh-btn" onclick="refreshCharts()">
                    <i class="fas fa-refresh"></i> Refresh Data
                </button>
                <canvas id="engagementChart" width="400" height="100"></canvas>
            </div>

            <!-- Posts Analytics -->
            <div class="analytics-card">
                <h3><i class="fas fa-edit"></i> Posts Analytics</h3>
                <div id="postsAnalytics">
                    <div class="loading">
                        <i class="fas fa-spinner"></i>
                        <p>Loading posts data...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentUser = null;
        let engagementChart = null;

        // Check login status on page load
        $(document).ready(function() {
            checkLoginStatus();
        });

        // Check if user is logged in
        function checkLoginStatus() {
            $.get('/app/status', function(response) {
                if (response.logged_in) {
                    currentUser = response.user;
                    showDashboard();
                    loadAnalyticsData();
                } else {
                    showLoginSection();
                }
            }).fail(function() {
                showLoginSection();
            });
        }

        // Show dashboard section
        function showDashboard() {
            $('#loginSection').hide();
            $('#dashboardSection').show();

            // Update user info
            $('#userName').text(currentUser.name);
            $('#userEmail').text('Email: ' + (currentUser.email || 'Not provided'));
            $('#userAvatar').attr('src', currentUser.avatar || '/assets/default-avatar.png');
            $('#loginTime').text('Connected: ' + new Date(currentUser.logged_in_at).toLocaleString());
        }

        // Show login section
        function showLoginSection() {
            $('#loginSection').show();
            $('#dashboardSection').hide();
        }

        // Load analytics data
        function loadAnalyticsData() {
            loadProfileAnalytics();
            loadPageInsights();
            loadRecentActivity();
            loadFriendsStats();
            loadPostsAnalytics();
            createEngagementChart();
        }

        // Load profile analytics using Facebook Graph API
        function loadProfileAnalytics() {
            $.get('/app/api/facebook/profile')
                .done(function(response) {
                    if (response.success) {
                        const profile = response.profile;
                        const profileData = {
                            'User ID': profile.id,
                            'Total Friends': profile.friends_count === 0 ? 'Private' : profile.friends_count || '0',
                            'Total Posts': profile.posts_count || '0',
                            'Profile Views': 'N/A', // Not available in basic permissions
                            'Account Status': 'Active'
                        };

                        let html = '';
                        Object.entries(profileData).forEach(([key, value]) => {
                            html += `<div class="stat-item">
                                <span>${key}</span>
                                <span class="stat-value">${value}</span>
                            </div>`;
                        });

                        $('#profileStats').html(html);
                    } else {
                        $('#profileStats').html('<p style="color: #e74c3c;">Failed to load profile data</p>');
                    }
                })
                .fail(function() {
                    // Show realistic error state
                    const profileData = {
                        'User ID': 'Not available',
                        'Total Friends': 'Private',
                        'Total Posts': '0',
                        'Profile Views': 'N/A',
                        'Account Status': 'Limited Access'
                    };

                    let html = '';
                    Object.entries(profileData).forEach(([key, value]) => {
                        html += `<div class="stat-item">
                            <span>${key}</span>
                            <span class="stat-value">${value}</span>
                        </div>`;
                    });

                    $('#profileStats').html(html);
                });
        }

        // Load page insights
        function loadPageInsights() {
            $.get('/app/api/facebook/pages')
                .done(function(response) {
                    if (response.success && response.pages.length > 0) {
                        const pages = response.pages;
                        const totalFans = pages.reduce((sum, page) => sum + (page.fan_count || 0), 0);
                        const totalTalkingAbout = pages.reduce((sum, page) => sum + (page.talking_about_count || 0), 0);

                        const pageData = {
                            'Managed Pages': pages.length,
                            'Total Page Likes': totalFans > 0 ? totalFans.toLocaleString() : '0',
                            'People Talking': totalTalkingAbout > 0 ? totalTalkingAbout.toLocaleString() : '0',
                            'Average Engagement': totalFans > 0 && totalTalkingAbout > 0 ? Math.round((
                                totalTalkingAbout / totalFans) * 100) + '%' : '0%',
                            'Page Insights': 'Limited Access'
                        };

                        let html = '';
                        Object.entries(pageData).forEach(([key, value]) => {
                            html += `<div class="stat-item">
                                <span>${key}</span>
                                <span class="stat-value">${value}</span>
                            </div>`;
                        });

                        $('#pageStats').html(html);
                    } else {
                        // Show when no pages or no permission
                        const pageData = {
                            'Managed Pages': '0',
                            'Total Page Likes': '0',
                            'People Talking': '0',
                            'Average Engagement': '0%',
                            'Access Level': 'Personal Account'
                        };

                        let html = '';
                        Object.entries(pageData).forEach(([key, value]) => {
                            html += `<div class="stat-item">
                                <span>${key}</span>
                                <span class="stat-value">${value}</span>
                            </div>`;
                        });

                        $('#pageStats').html(html);
                    }
                })
                .fail(function() {
                    const pageData = {
                        'Managed Pages': '0',
                        'Total Page Likes': 'N/A',
                        'People Talking': 'N/A',
                        'Access Status': 'Permission Denied',
                        'Account Type': 'Personal'
                    };

                    let html = '';
                    Object.entries(pageData).forEach(([key, value]) => {
                        html += `<div class="stat-item">
                            <span>${key}</span>
                            <span class="stat-value">${value}</span>
                        </div>`;
                    });

                    $('#pageStats').html(html);
                });
        }

        // Load recent activity
        function loadRecentActivity() {
            // Since we don't have access to user activity feed, show realistic limitation
            const activities = [{
                    action: 'Login Activity',
                    value: 'Just now'
                },
                {
                    action: 'Token Generated',
                    value: '1 min ago'
                },
                {
                    action: 'Data Request',
                    value: '1 min ago'
                },
                {
                    action: 'Profile Access',
                    value: '2 mins ago'
                },
                {
                    action: 'App Permission',
                    value: 'Today'
                }
            ];

            let html = '';
            activities.forEach((activity) => {
                html += `<div class="stat-item">
                    <span>${activity.action}</span>
                    <span class="stat-value">${activity.value}</span>
                </div>`;
            });

            // Add note about limited access
            html += `<div style="margin-top: 10px; padding: 8px; background: rgba(255,193,7,0.1); border-radius: 5px; font-size: 12px; color: #856404;">
                <i class="fas fa-info-circle"></i> Activity feed requires additional permissions
            </div>`;

            $('#recentActivity').html(html);
        }

        // Load friends statistics
        function loadFriendsStats() {
            // Most friend data is not available through basic permissions
            const friendsData = {
                'Friends List': 'Private',
                'Mutual Friends': 'N/A',
                'Friend Requests': 'N/A',
                'Close Friends': 'N/A',
                'Access Level': 'Basic'
            };

            let html = '';
            Object.entries(friendsData).forEach(([key, value]) => {
                html += `<div class="stat-item">
                    <span>${key}</span>
                    <span class="stat-value">${value}</span>
                </div>`;
            });

            // Add explanation note
            html += `<div style="margin-top: 10px; padding: 8px; background: rgba(23,162,184,0.1); border-radius: 5px; font-size: 12px; color: #0c5460;">
                <i class="fas fa-shield-alt"></i> Facebook restricts friend data access for privacy
            </div>`;

            $('#friendsStats').html(html);
        }

        // Load posts analytics
        function loadPostsAnalytics() {
            $.get('/app/api/facebook/posts')
                .done(function(response) {
                    if (response.success) {
                        const analytics = response.analytics;
                        const postsData = {
                            'Total Posts': analytics.total_posts || '0',
                            'Total Likes': analytics.total_likes > 0 ? analytics.total_likes.toLocaleString() : '0',
                            'Total Comments': analytics.total_comments > 0 ? analytics.total_comments
                                .toLocaleString() : '0',
                            'Average Likes': analytics.avg_likes_per_post > 0 ? Math.round(analytics
                                .avg_likes_per_post) : '0',
                            'Engagement Rate': analytics.engagement_rate > 0 ? analytics.engagement_rate + '%' :
                                '0%'
                        };

                        let html = '';
                        Object.entries(postsData).forEach(([key, value]) => {
                            html += `<div class="stat-item">
                                <span>${key}</span>
                                <span class="stat-value">${value}</span>
                            </div>`;
                        });

                        // Add note about data availability
                        if (analytics.total_posts === 0) {
                            html += `<div style="margin-top: 10px; padding: 8px; background: rgba(108,117,125,0.1); border-radius: 5px; font-size: 12px; color: #495057;">
                                <i class="fas fa-info-circle"></i> No recent posts found or posts are private
                            </div>`;
                        }

                        $('#postsAnalytics').html(html);

                        // Update engagement chart with real data
                        if (engagementChart && response.posts.length > 0) {
                            const posts = response.posts.slice(0, 7); // Last 7 posts
                            const labels = posts.map(post => new Date(post.created_time).toLocaleDateString('en-US', {
                                month: 'short',
                                day: 'numeric'
                            }));
                            const likes = posts.map(post => post.likes ? post.likes.summary.total_count : 0);
                            const comments = posts.map(post => post.comments ? post.comments.summary.total_count : 0);
                            const reactions = posts.map(post => post.reactions ? post.reactions.summary.total_count :
                                0);

                            engagementChart.data.labels = labels.reverse();
                            engagementChart.data.datasets[0].data = likes.reverse();
                            engagementChart.data.datasets[1].data = comments.reverse();
                            engagementChart.data.datasets[2].data = reactions.reverse();
                            engagementChart.update();
                        } else if (engagementChart) {
                            // Show empty chart when no data
                            engagementChart.data.labels = ['No Data', '', '', '', '', '', ''];
                            engagementChart.data.datasets[0].data = [0, 0, 0, 0, 0, 0, 0];
                            engagementChart.data.datasets[1].data = [0, 0, 0, 0, 0, 0, 0];
                            engagementChart.data.datasets[2].data = [0, 0, 0, 0, 0, 0, 0];
                            engagementChart.update();
                        }
                    } else {
                        $('#postsAnalytics').html(
                            '<p style="color: #e74c3c;">Permission denied or no posts available</p>');
                    }
                })
                .fail(function() {
                    // Show realistic error state with zeros
                    const postsData = {
                        'Total Posts': '0',
                        'Total Likes': '0',
                        'Total Comments': '0',
                        'Average Likes': '0',
                        'Access Status': 'Limited'
                    };

                    let html = '';
                    Object.entries(postsData).forEach(([key, value]) => {
                        html += `<div class="stat-item">
                            <span>${key}</span>
                            <span class="stat-value">${value}</span>
                        </div>`;
                    });

                    html += `<div style="margin-top: 10px; padding: 8px; background: rgba(220,53,69,0.1); border-radius: 5px; font-size: 12px; color: #721c24;">
                        <i class="fas fa-exclamation-triangle"></i> Posts data requires additional permissions
                    </div>`;

                    $('#postsAnalytics').html(html);
                });
        }

        // Create engagement chart
        function createEngagementChart() {
            setTimeout(() => {
                const ctx = document.getElementById('engagementChart').getContext('2d');

                engagementChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['No Data Available', '', '', '', '', '', ''],
                        datasets: [{
                            label: 'Likes',
                            data: [0, 0, 0, 0, 0, 0, 0],
                            borderColor: '#4267B2',
                            backgroundColor: 'rgba(66, 103, 178, 0.1)',
                            tension: 0.4
                        }, {
                            label: 'Comments',
                            data: [0, 0, 0, 0, 0, 0, 0],
                            borderColor: '#42b883',
                            backgroundColor: 'rgba(66, 184, 131, 0.1)',
                            tension: 0.4
                        }, {
                            label: 'Reactions',
                            data: [0, 0, 0, 0, 0, 0, 0],
                            borderColor: '#f39c12',
                            backgroundColor: 'rgba(243, 156, 18, 0.1)',
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Post Engagement Analytics (Requires Posts Access)'
                            },
                            legend: {
                                display: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Engagement Count'
                                }
                            }
                        }
                    }
                });

                // Add note about chart data
                setTimeout(() => {
                    const chartContainer = document.querySelector('.chart-container');
                    const noteDiv = document.createElement('div');
                    noteDiv.style.cssText =
                        'margin-top: 10px; padding: 8px; background: rgba(23,162,184,0.1); border-radius: 5px; font-size: 12px; color: #0c5460; text-align: center;';
                    noteDiv.innerHTML =
                        '<i class="fas fa-info-circle"></i> Chart will populate with real data when posts are accessible';
                    chartContainer.appendChild(noteDiv);
                }, 100);
            }, 1000);
        }

        // Refresh charts
        function refreshCharts() {
            if (engagementChart) {
                // Generate new random data
                engagementChart.data.datasets.forEach(dataset => {
                    dataset.data = dataset.data.map(() => Math.floor(Math.random() * 100));
                });
                engagementChart.update();
            }

            // Reload analytics data
            loadAnalyticsData();
        }

        // Logout function
        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = '/app/logout';
            }
        }

        // Auto-refresh data every 5 minutes
        setInterval(() => {
            if (currentUser) {
                loadAnalyticsData();
            }
        }, 300000); // 5 minutes
    </script>
</body>

</html>

</head>

<body>


    <div class="container">
        <!-- Login Success Message -->
        @if (session('login_success'))
            <div class="notification" style="background-color: #d1ecf1; color: #0c5460;">
                <i class="fas fa-check-circle"></i> {{ session('login_success') }}
            </div>
        @endif

        <!-- Login Error Message -->
        @if (session('login_error'))
            <div class="notification" style="background-color: #f8d7da; color: #721c24;">
                <i class="fas fa-exclamation-triangle"></i> {{ session('login_error') }}
            </div>
        @endif

        <!-- Logout Success Message -->
        @if (session('logout_success'))
            <div class="notification" style="background-color: #fff3cd; color: #856404;">
                <i class="fas fa-sign-out-alt"></i> {{ session('logout_success') }}
            </div>
        @endif

        <!-- Check if user is already logged in -->
        @if (session('facebook_user'))
            <div class="login-section">
                <div class="user-profile" style="margin-bottom: 20px;">
                    <img src="{{ session('facebook_user.avatar') }}" alt="Profile"
                        style="width: 60px; height: 60px; border-radius: 50%; margin-bottom: 10px;">
                    <h3 style="color: #4267B2; margin: 10px 0;">{{ session('facebook_user.name') }}</h3>
                    <p style="color: #ccc; font-size: 14px;">{{ session('facebook_user.email') }}</p>
                </div>

                <div class="post-info">
                    You are now logged in! You can submit any link and take our service on any Public Posts.
                </div>

                <button class="facebook-btn" style="background-color: #dc3545;" onclick="logoutFacebook()">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout from Facebook
                </button>
            </div>
        @endif
    </div>

    <script>
        let timerActive = false;
        let countdown = 15;
        let timerInterval;

        function clearSession() {
            // Check if this is a Flutter app context
            if (window.flutter_inappwebview && window.flutter_inappwebview.callHandler) {
                // Notify Flutter app to open login dialog
                window.flutter_inappwebview.callHandler('clearSession');

            }
        }

        function handleFacebookLogin() {
            if (timerActive) {
                return;
            }

            // Check if this is a Flutter app context
            if (window.flutter_inappwebview && window.flutter_inappwebview.callHandler &&
                {{ !$config['useRealFacebookLogin'] ? 'true' : 'false' }}) {
                // Notify Flutter app to open login dialog
                window.flutter_inappwebview.callHandler('openFacebookLogin');
                startTimer();
            } else {
                // Web-based Facebook OAuth login
                showLoadingState();
                window.location.href = "{{ route('app.facebook.login') }}";
            }
        }

        function logoutFacebook() {
            if (confirm('Are you sure you want to logout from Facebook?')) {
                showLoadingState();
                window.location.href = "{{ route('app.facebook.logout') }}";
            }
        }

        function showLoadingState() {
            $('.facebook-btn').html('<i class="fas fa-spinner fa-spin"></i> Please wait...');
            $('.facebook-btn').css({
                'background-color': '#ccc',
                'cursor': 'not-allowed'
            });
        }

        function startTimer() {
            timerActive = true;
            countdown = 15;

            $('#timerDisplay').show();
            $('.facebook-btn').css({
                'background-color': '#ccc',
                'cursor': 'not-allowed'
            });

            timerInterval = setInterval(function() {
                countdown--;
                $('#countdown').text(countdown);

                if (countdown <= 0) {
                    clearInterval(timerInterval);
                    timerActive = false;
                    $('#timerDisplay').hide();
                    $('.facebook-btn').css({
                        'background-color': '#4267B2',
                        'cursor': 'pointer'
                    });
                }
            }, 1000);
        }

        // Function to be called from Flutter when login is successful
        function onLoginSuccess() {
            if (timerInterval) {
                clearInterval(timerInterval);
            }
            timerActive = false;
            $('#timerDisplay').hide();
            $('.facebook-btn').css({
                'background-color': '#4267B2',
                'cursor': 'pointer'
            });

            // Show success message
            $('.notification').text('Login Successful! Redirecting...').css({
                'background-color': '#d1ecf1',
                'color': '#0c5460'
            });

            // Reload page to show logged in state
            setTimeout(function() {
                window.location.reload();
            }, 1500);
        }

        // Function to reset timer from Flutter
        function resetTimer() {
            if (timerInterval) {
                clearInterval(timerInterval);
            }
            timerActive = false;
            countdown = 15;
            $('#timerDisplay').hide();
            $('.facebook-btn').css({
                'background-color': '#4267B2',
                'cursor': 'pointer'
            });
        }

        // Auto-hide success/error messages after 5 seconds
        $(document).ready(function() {
            @if (session('login_success') || session('login_error') || session('logout_success'))
                setTimeout(function() {
                    $('.notification').fadeOut('slow');
                }, 5000);
            @endif

            // Handle login success from session
            @if (session('login_success'))
                // Scroll to profile section
                setTimeout(function() {
                    $('.login-section').get(0).scrollIntoView({
                        behavior: 'smooth'
                    });
                }, 500);
            @endif
        });

        // Enhanced click handlers
        $('.facebook-btn').on('click', function() {
            $(this).addClass('animate__pulse');
            setTimeout(function() {
                $('.facebook-btn').removeClass('animate__pulse');
            }, 600);
        });
    </script>
</body>

</html>
