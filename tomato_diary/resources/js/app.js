// resources/js/app.js

import './bootstrap';
import './mouse_stalker.js'; //mouse stalker

// FullCalendar関連のインポート
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

// ドキュメントが完全にロードされた後にFullCalendarを初期化
document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM Content Loaded."); // ログを追加

    var calendarEl = document.getElementById('calendar');

    if (calendarEl) {
        console.log("Calendar element found."); // ログを追加

        // data-events 属性からイベントデータを取得
        // JSON.parse() の前に、値が存在し、かつ文字列であることを確認
        var eventsData = [];
        if (calendarEl.dataset.events) {
            try {
                eventsData = JSON.parse(calendarEl.dataset.events);
                console.log("Events data parsed:", eventsData); // ログを追加
            } catch (e) {
                console.error("Error parsing events data:", e); // エラーログ
            }
        } else {
            console.log("No data-events attribute found on calendar element."); // ログを追加
        }


        // FullCalendarが定義されているか最終確認 (念のため)
        if (typeof Calendar === 'undefined') {
            console.error("FullCalendar.Calendar is not defined at initialization time.");
            return; // 定義されていなければここで処理を中断
        }


        var calendar = new Calendar(calendarEl, {
            plugins: [ dayGridPlugin, interactionPlugin ],
            initialView: 'dayGridMonth',
            locale: 'ja',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            events: eventsData, // ここにイベントデータが渡される
            eventClick: function(info) {
                // 日記がある日は、diary/index ページにスクロールする
                info.jsEvent.preventDefault(); 

                // `window.diaryIndexBaseUrl` が適切に定義されていることを前提とします。
                const eventDate = info.event.start.toISOString().substring(0, 10);
                window.location.href = `${window.diaryIndexBaseUrl}?date=${eventDate}`;
            },
            dateClick: function(info) {
                alert('この日は、日記がありません。: ' + info.dateStr);
            },
            // データが入っている日だけマークを付けるオプション (例: ドット表示)
            eventDisplay: 'dot' // これを追加して試してみてください
        });
        calendar.render();
        console.log("FullCalendar rendered."); // ログを追加

    } else {
        console.log("Calendar element #calendar not found.");
    }
});