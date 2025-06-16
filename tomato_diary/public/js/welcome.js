document.addEventListener('DOMContentLoaded', function() {
    // アニメーション用の要素を取得
    const animationContainer = document.getElementById('animation-container');
    const bigTomato = document.getElementById('big-tomato');
    const nextScreen = document.getElementById('next-screen');
    const nextPageButton = document.getElementById('next-page-button');
    const adminPageButton = document.getElementById('admin-page-button');

    // トマトの画像パスを取得
    const tomatoImagePath = document.body.dataset.tomatoImagePath;
    const cannedTomatoImagePath = document.body.dataset.cannedTomatoImagePath;
    const soundPath = document.body.dataset.soundPath;
    const bounceSoundPath = document.body.dataset.bounceSoundPath;

    // サウンドの読み込み
    const tomatoSound = new Audio(soundPath);
    const bounceSound = new Audio(bounceSoundPath);

    // 音声の読み込みを確認
    tomatoSound.addEventListener('canplaythrough', () => {
        console.log('ウグイスの音声が読み込まれました');
    });

    tomatoSound.addEventListener('error', (e) => {
        console.error('音声の読み込みエラー:', e);
    });

    // トマトを生成する関数
    function createTomato() {
        const tomato = document.createElement('img');
        tomato.src = Math.random() > 0.8 ? cannedTomatoImagePath : tomatoImagePath;
        tomato.className = 'falling-tomato';
        tomato.style.left = Math.random() * (window.innerWidth - 70) + 'px';
        animationContainer.appendChild(tomato);

        // アニメーション終了時に要素を削除
        tomato.addEventListener('animationend', () => {
            tomato.remove();
        });

        // トマトが画面の中央を過ぎたときに音を鳴らす
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) {
                    try {
                        tomatoSound.currentTime = 0;
                        const playPromise = tomatoSound.play();
                        
                        if (playPromise !== undefined) {
                            playPromise.catch(error => {
                                console.error('音声再生エラー:', error);
                            });
                        }
                    } catch (error) {
                        console.error('音声再生エラー:', error);
                    }
                    observer.disconnect();
                }
            });
        }, {
            threshold: 0.5
        });

        observer.observe(tomato);
    }

    // 定期的にトマトを生成
    let tomatoInterval = setInterval(createTomato, 600);

    // ボタンのイベントリスナー
    nextPageButton.addEventListener('click', function() {
        // トマトの生成を停止
        clearInterval(tomatoInterval);
        
        // 大きなトマトを表示
        bigTomato.classList.add('falling');

        // バウンド音を再生するタイミングを設定
        setTimeout(() => {
            bounceSound.currentTime = 0;
            bounceSound.play();
        }, 400); // アニメーションの20%の位置で音を再生

        // 2秒後に次の画面を表示して遷移
        setTimeout(() => {
            nextScreen.classList.add('fade-in');
            setTimeout(() => {
                window.location.href = '/';
            }, 1000);
        }, 2000);
    });

    adminPageButton.addEventListener('click', function() {
        window.location.href = '/login';
    });

    // タイトルのアニメーション
    const title = document.getElementById('animated-title');
    title.style.opacity = '0';
    setTimeout(() => {
        title.style.transition = 'opacity 1s ease-in-out';
        title.style.opacity = '1';
    }, 500);
}); 