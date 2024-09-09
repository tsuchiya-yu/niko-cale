import axios from 'axios';

document.addEventListener('DOMContentLoaded', function () {
    const deleteLink = document.querySelector('.js-delete');

    deleteLink.addEventListener('click', function () {
        const uuid = this.getAttribute('data-uuid');

        if (confirm('本当にこのカレンダーを削除してもよろしいですか？')) {
            axios.delete(`/api/v1/calendars/${uuid}`)
                .then(response => {
                    if (response.data.success) {
                        alert('カレンダーが削除されました。');
                        window.location.href = '/';
                    } else {
                        alert('カレンダーの削除に失敗しました。');
                    }
                })
                .catch(error => {
                    console.error('削除エラー:', error);
                    alert('カレンダーの削除中にエラーが発生しました。');
                });
        }
    });
});
