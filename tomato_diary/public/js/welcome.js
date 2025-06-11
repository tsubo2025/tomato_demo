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

    // トマトを生成する関数
    function createTomato() {
        const tomato = document.createElement('img');
        tomato.src = Math.random() > 0.8 ? cannedTomatoImagePath : tomatoImagePath;
        tomato.className = 'falling-tomato';
        tomato.style.left = Math.random() * (window.innerWidth - 70) + 'px';
        animationContainer.appendChild(tomato);

        // 落下アニメーション
        let position = -70;
        const speed = 2 + Math.random() * 3;
        const rotation = Math.random() * 360;

        function animate() {
            position += speed;
            tomato.style.transform = `translateY(${position}px) rotate(${rotation}deg)`;

            if (position < window.innerHeight + 70) {
                requestAnimationFrame(animate);
            } else {
                tomato.remove();
            }
        }

        animate();
        tomatoSound.currentTime = 0;
        tomatoSound.play();
    }

    // 定期的にトマトを生成
    let tomatoInterval = setInterval(createTomato, 2000);

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