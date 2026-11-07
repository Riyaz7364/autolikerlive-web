<div class="ads-top" aria-label="Advertisement">
    <style>
        .ads-top__desktop { display: block; }
        .ads-top__mobile { display: none; }

        @media (max-width: 767.98px) {
            .ads-top__desktop { display: none !important; }
            .ads-top__mobile { display: block !important; }
        }
    </style>
    <div class="ads-top__desktop"><x-ads.leaderboard /></div>
    <div class="ads-top__mobile"><x-ads.mobile-banner /></div>
</div>
