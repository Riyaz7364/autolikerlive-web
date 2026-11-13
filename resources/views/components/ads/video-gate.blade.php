@php
    $promoVideo = \App\Support\PromoVideos::random();
    $promoVideoUrl = $promoVideo['url'];
    $promoVideoLink = $promoVideo['link'];
@endphp
<div id="video-ad-gate" class="video-ad-gate" hidden>
    <div class="video-ad-gate__backdrop"></div>
    <section class="video-ad-gate__dialog" role="dialog" aria-modal="true" aria-labelledby="video-ad-gate-title">
        <button type="button" class="video-ad-gate__close" aria-label="Close video advertisement">&times;</button>
        <h2 id="video-ad-gate-title">Watch a video ad to continue</h2>
        <p>Watch the promotion video to submit your request.</p>
        <div class="video-ad-gate__stage" hidden>
            <video class="video-ad-gate__video" playsinline></video>
        </div>
        <p class="video-ad-gate__status" role="status" aria-live="polite">Ready to play.</p>
        <button type="button" class="video-ad-gate__play">Play video</button>
        <button type="button" class="video-ad-gate__cancel">Cancel request</button>
    </section>
</div>

<style>
    .video-ad-gate[hidden],
    .video-ad-gate__stage[hidden] { display: none !important; }
    .video-ad-gate { position: fixed; inset: 0; z-index: 100000; display: grid; place-items: center; padding: 18px; font-family: Arial, sans-serif; }
    .video-ad-gate__backdrop { position: absolute; inset: 0; background: rgba(0, 0, 0, .78); }
    .video-ad-gate__dialog { position: relative; z-index: 1; width: min(100%, 720px); padding: 24px; border-radius: 16px; background: #101318; color: #fff; box-shadow: 0 20px 70px rgba(0, 0, 0, .5); text-align: center; }
    .video-ad-gate__dialog h2 { margin: 0 38px 8px; font-size: 20px; font-weight: 700; }
    .video-ad-gate__dialog p { margin: 8px 0 16px; color: #d1d5db; }
    .video-ad-gate__close { position: absolute; top: 10px; right: 12px; border: 0; background: transparent; color: #fff; font-size: 28px; cursor: pointer; }
    .video-ad-gate__stage { position: relative; width: 100%; aspect-ratio: 16 / 9; overflow: hidden; background: #000; }
    .video-ad-gate__video { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: contain; cursor: pointer; }
    .video-ad-gate__status { min-height: 1.4em; }
    .video-ad-gate__play,
    .video-ad-gate__cancel { min-height: 44px; margin: 4px; padding: 10px 18px; border: 0; border-radius: 8px; font-weight: 700; cursor: pointer; }
    .video-ad-gate__play { background: #fbbf24; color: #111827; }
    .video-ad-gate__play:disabled { cursor: wait; opacity: .6; }
    .video-ad-gate__cancel { background: #374151; color: #fff; }
    .video-ad-gate__dialog:fullscreen,
    .video-ad-gate__dialog:-webkit-full-screen,
    .video-ad-gate.is-fullscreen .video-ad-gate__dialog { display: flex; flex-direction: column; box-sizing: border-box; width: 100vw; max-width: none; height: 100vh; height: 100dvh; padding: max(16px, env(safe-area-inset-top)) max(14px, env(safe-area-inset-right)) max(16px, env(safe-area-inset-bottom)) max(14px, env(safe-area-inset-left)); border-radius: 0; }
    .video-ad-gate__dialog:fullscreen .video-ad-gate__stage,
    .video-ad-gate__dialog:-webkit-full-screen .video-ad-gate__stage,
    .video-ad-gate.is-fullscreen .video-ad-gate__stage { flex: 1; min-height: 0; aspect-ratio: auto; }
    .video-ad-gate__dialog:fullscreen h2,
    .video-ad-gate__dialog:-webkit-full-screen h2,
    .video-ad-gate.is-fullscreen .video-ad-gate__dialog h2 { flex: none; }
    .video-ad-gate__dialog:fullscreen p,
    .video-ad-gate__dialog:-webkit-full-screen p,
    .video-ad-gate.is-fullscreen .video-ad-gate__dialog p { flex: none; }
    @media (max-width: 520px) {
        .video-ad-gate { padding: 0; }
        .video-ad-gate.is-fullscreen .video-ad-gate__dialog { padding-top: max(12px, env(safe-area-inset-top)); }
    }
</style>

<script>
    (function () {
        var mode = @json($mode ?? 'forms');
        var promoVideo = @json($promoVideoUrl);
        var promoVideoLink = @json($promoVideoLink);
        var gate = document.getElementById('video-ad-gate');
        var stage = gate.querySelector('.video-ad-gate__stage');
        var video = gate.querySelector('.video-ad-gate__video');
        var status = gate.querySelector('.video-ad-gate__status');
        var playButton = gate.querySelector('.video-ad-gate__play');
        var pendingAction = null;
        var activeCleanup = null;
        var previousOverflow = '';
        var allowedForms = new WeakSet();
        var allowedButtons = new WeakSet();
        var playlistSettled = true;

        function setStatus(message) {
            status.textContent = message;
        }

        function isAppRequestForm(form) {
            return form && ['reactionForm', 'followersForm', 'commentsForm'].indexOf(form.id) !== -1;
        }

        function openGate(action) {
            if (pendingAction) return;
            pendingAction = action;
            previousOverflow = document.body.style.overflow;
            document.body.style.overflow = 'hidden';
            gate.hidden = false;
            playButton.hidden = false;
            playButton.disabled = false;
            stage.hidden = true;
            setStatus(promoVideoLink
                ? 'Press play and watch the video. Tap the video to open its link.'
                : 'Press play and watch the video to continue.');
        }

        function closeGate() {
            if (activeCleanup) activeCleanup(false, '', false);
            pendingAction = null;
            gate.hidden = true;
            document.body.style.overflow = previousOverflow;
            exitFullscreen();
        }

        function exitFullscreen() {
            gate.classList.remove('is-fullscreen');
            if (document.fullscreenElement === gate.querySelector('.video-ad-gate__dialog')) {
                document.exitFullscreen().catch(function (error) {
                    console.warn('Could not exit video ad fullscreen:', error);
                });
            } else if (document.webkitFullscreenElement === gate.querySelector('.video-ad-gate__dialog') &&
                document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            }
        }

        function continueRequest() {
            var action = pendingAction;
            pendingAction = null;
            gate.hidden = true;
            document.body.style.overflow = previousOverflow;
            exitFullscreen();
            if (!action) return;

            if (action.kind === 'form') {
                allowedForms.add(action.form);
                try {
                    if (action.submitter && action.submitter.isConnected && !action.submitter.disabled) {
                        action.form.requestSubmit(action.submitter);
                    } else {
                        action.form.requestSubmit();
                    }
                } catch (error) {
                    console.error('Could not resume the form after video ad completion:', error);
                    setStatus('The request could not be resumed. Please submit it again.');
                } finally {
                    allowedForms.delete(action.form);
                }
                return;
            }

            if (action.button && action.button.isConnected && !action.button.disabled) {
                allowedButtons.add(action.button);
                action.button.click();
                allowedButtons.delete(action.button);
            } else if (action.form && action.form.isConnected) {
                var button = action.form.querySelector('button[type="submit"]:not(:disabled)');
                if (button) {
                    allowedButtons.add(button);
                    button.click();
                    allowedButtons.delete(button);
                }
            }
        }

        function playPromoVideo() {
            if (playlistSettled) return;
            if (!promoVideo) {
                finishPlaylist(false, 'No promotion video is available right now. Please try again.');
                return;
            }
            setStatus('Playing video...');
            video.src = promoVideo;
            video.load();
            var playPromise = video.play();
            if (playPromise && typeof playPromise.catch === 'function') {
                playPromise.catch(function (error) {
                    console.error('Could not play the promotion video:', error);
                    finishPlaylist(false, 'The video could not play. Please try again.');
                });
            }
        }

        function finishPlaylist(success, message) {
            if (activeCleanup) activeCleanup(success, message, success);
        }

        function runAd() {
            var dialog = gate.querySelector('.video-ad-gate__dialog');
            gate.classList.add('is-fullscreen');
            var requestFullscreen = dialog.requestFullscreen || dialog.webkitRequestFullscreen;
            if (requestFullscreen) {
                try {
                    var fullscreenRequest = requestFullscreen.call(dialog);
                    if (fullscreenRequest && typeof fullscreenRequest.catch === 'function') {
                        fullscreenRequest.catch(function () {
                            gate.classList.add('is-fullscreen');
                        });
                    }
                } catch (error) {
                    gate.classList.add('is-fullscreen');
                }
            }

            playButton.hidden = true;
            stage.hidden = false;
            playlistSettled = false;

            function cleanup(success, message, resume) {
                if (playlistSettled) return;
                playlistSettled = true;
                if (activeCleanup === cleanup) activeCleanup = null;

                video.pause();
                video.removeAttribute('src');
                video.load();
                stage.hidden = true;

                if (success && resume) {
                    continueRequest();
                } else if (!gate.hidden) {
                    playButton.hidden = false;
                    playButton.disabled = false;
                    setStatus(message || 'The video was not completed. Watch it to continue.');
                }
            }

            activeCleanup = cleanup;
            playPromoVideo();
        }

        document.addEventListener('submit', function (event) {
            var form = event.target;
            var isAppForm = mode === 'app' && isAppRequestForm(form);
            var isMarkedForm = mode === 'forms' && form && form.hasAttribute('data-video-ad-gate');
            if (!isAppForm && !isMarkedForm) return;
            if (allowedForms.has(form)) {
                allowedForms.delete(form);
                return;
            }

            event.preventDefault();
            event.stopImmediatePropagation();
            if (isAppForm) {
                openGate({
                    kind: 'app',
                    form: form,
                    button: event.submitter || form.querySelector('button[type="submit"]')
                });
            } else {
                openGate({ kind: 'form', form: form, submitter: event.submitter });
            }
        }, true);

        if (mode === 'app') {
            document.addEventListener('click', function (event) {
                var button = event.target.closest('#submitBtn, #submitFollowersBtn, #submitCommentsBtn');
                if (!button) return;
                if (allowedButtons.has(button)) {
                    allowedButtons.delete(button);
                    return;
                }

                event.preventDefault();
                event.stopImmediatePropagation();
                openGate({ kind: 'app', form: button.form, button: button });
            }, true);
        }

        playButton.addEventListener('click', runAd);
        if (promoVideoLink) {
            video.style.cursor = 'pointer';
            video.title = 'Open link';
        }
        video.addEventListener('click', function () {
            if (!promoVideoLink) return;
            window.open(promoVideoLink, '_blank', 'noopener');
        });
        video.addEventListener('ended', function () {
            if (playlistSettled) return;
            finishPlaylist(true, '');
        });
        video.addEventListener('error', function () {
            if (playlistSettled) return;
            console.error('Promotion video error:', video.error);
            finishPlaylist(false, 'The video could not play. Please try again.');
        });
        gate.querySelector('.video-ad-gate__close').addEventListener('click', closeGate);
        gate.querySelector('.video-ad-gate__cancel').addEventListener('click', closeGate);
        gate.querySelector('.video-ad-gate__backdrop').addEventListener('click', closeGate);
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !gate.hidden) closeGate();
        });
    })();
</script>
