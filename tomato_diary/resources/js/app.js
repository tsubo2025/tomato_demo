import './bootstrap';

import './mouse_stalker.js'; //mouse stalker

// --- ここからFullCalendar関連の追加コード ---

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    if (calendarEl) { // calendarElが存在する場合のみ初期化
        var calendar = new Calendar(calendarEl, {
            plugins: [ dayGridPlugin, interactionPlugin ],
            initialView: 'dayGridMonth',
            locale: 'ja',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            // events のデータはdashboard.blade.phpから @json($events) で直接渡される
            // ここでは設定しない
            eventClick: function(info) {
                if (info.event.url) {
                    info.jsEvent.preventDefault();
                    window.location.href = info.event.url;
                } else {
                    alert('イベント: ' + info.event.title);
                }
            },
            dateClick: function(info) {
                alert('日付がクリックされました: ' + info.dateStr);
                // 例: その日の日記作成ページへ遷移
                // window.location.href = '/diary/create?date=' + info.dateStr;
            }
        });
        calendar.render();
    }
});