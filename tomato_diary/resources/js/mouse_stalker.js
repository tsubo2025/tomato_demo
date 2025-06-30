// resources/js/mouse_stalker.js

document.addEventListener('DOMContentLoaded', () => {
    console.log('Mouse stalker script loaded'); // デバッグ用
    
    const tomato = document.createElement('div');
    tomato.classList.add('mouse-stalker');
    tomato.id = 'mouse-stalker-tomato'; // IDを追加

    // 画像の読み込みテスト
    const testImg = new Image();
    testImg.onload = function() {
        console.log('Tomato image loaded successfully');
    };
    testImg.onerror = function() {
        console.error('Failed to load tomato image');
    };
    testImg.src = '/image/tomato/tomato_red.png';

    // CSSで背景画像として設定
    tomato.style.backgroundImage = 'url(/image/tomato/tomato_red.png)';
    tomato.style.backgroundSize = 'contain';
    tomato.style.backgroundRepeat = 'no-repeat';
    tomato.style.width = '40px';
    tomato.style.height = '40px';
    tomato.style.position = 'fixed';
    tomato.style.pointerEvents = 'none';
    tomato.style.zIndex = '9999';

    document.body.appendChild(tomato);
    console.log('Tomato element added to body'); // デバッグ用

    document.addEventListener('mousemove', (e) => {
        tomato.style.transform = `translate(${e.clientX - 20}px, ${e.clientY - 20}px)`;
    });
    
    console.log('Mouse move event listener added'); // デバッグ用
    // ... 他のイベントリスナー（mouseout/mouseover）
});