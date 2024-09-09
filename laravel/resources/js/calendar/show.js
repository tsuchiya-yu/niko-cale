import axios from 'axios';

document.addEventListener('DOMContentLoaded', () => {
    setupCopyButton();
    setupCells();
    setupModalClose();
    setupEditButton();
    setupResetButton();
});

function setupCopyButton() {
    document.querySelectorAll('.js-copy').forEach(element => {
        element.addEventListener('click', copyUrlToClipboard);
    });
}

function copyUrlToClipboard(event) {
    const urlInput = document.querySelector('input[name="url"]');
    urlInput.select();
    document.execCommand('copy');
    alert('URLをコピーしました！');
}

function setupCells() {
    const cells = document.querySelectorAll('.cell');
    cells.forEach(cell => {
        cell.addEventListener('click', handleCellClick);
    });
}

function handleCellClick(event) {
    const cell = event.currentTarget;
    const memberId = cell.getAttribute('data-member-id');
    const date = cell.getAttribute('data-date');
    const name = cell.getAttribute('data-name');

    setModalContent(memberId, date, name);
    showModal();
}

function setModalContent(memberId, date, name) {
    document.getElementById('modalMemberId').textContent = memberId;
    document.getElementById('modalDate').textContent = date;
    document.getElementById('modalName').textContent = name;
}

function showModal() {
    document.getElementById('conditionModal').style.display = "block";
}

function setupModalClose() {
    const closeModal = document.querySelector('.modal .close');
    closeModal.addEventListener('click', hideModal);

    window.addEventListener('click', event => {
        if (event.target === document.getElementById('conditionModal')) {
            hideModal();
        }
    });
}

function hideModal() {
    const modal = document.getElementById('conditionModal');
    modal.style.display = "none";
    clearSelectedMood();
}

function clearSelectedMood() {
    const selectedWrapIcon = document.querySelector('.wrap-icon.selected');
    if (selectedWrapIcon) {
        selectedWrapIcon.classList.remove('selected');
        selectedWrapIcon.style.border = "2px solid transparent";
    }
}

function setupEditButton() {
    document.getElementById('edit-button').addEventListener('click', handleEditButtonClick);

    document.querySelectorAll('.wrap-icon').forEach(iconWrap => {
        iconWrap.addEventListener('click', handleMoodIconClick);
    });
}

function handleMoodIconClick(event) {
    clearSelectedMood();
    const wrapIcon = event.currentTarget;
    const icon = wrapIcon.querySelector('.mood-icon');
    wrapIcon.classList.add('selected');
    wrapIcon.style.border = "2px solid #000";
    wrapIcon.style.borderRadius = "16px";
    icon.classList.add('selected');
}

function handleEditButtonClick() {
    const selectedMoodIcon = document.querySelector('.mood-icon.selected');
    if (selectedMoodIcon) {
        const condition = selectedMoodIcon.getAttribute('data-mood');
        const memberId = document.getElementById('modalMemberId').textContent;
        const date = document.getElementById('modalDate').textContent;

        axios.post('/api/v1/member-condition/update', {
            calendar_member_id: memberId,
            date: date,
            condition: condition
        })
        .then(response => {
            if (response.data) {
                location.reload();
            } else {
                alert('更新に失敗しました。');
            }
        })
        .catch(error => {
            console.error('Error updating condition:', error);
            alert('更新中にエラーが発生しました。');
        });

        hideModal();
    } else {
        alert("調子を選択してください！");
    }
}

function setupResetButton() {
    document.getElementById('reset-button').addEventListener('click', handleResetButtonClick);
}

function handleResetButtonClick() {
    const memberId = document.getElementById('modalMemberId').textContent;
    const date = document.getElementById('modalDate').textContent;

    axios.delete('/api/v1/member-condition', {
        data: {
            calendar_member_id: memberId,
            date: date
        }
    })
    .then(response => {
        if (response.data.success) {
            location.reload();
        } else {
            alert('リセットに失敗しました。');
        }
    })
    .catch(error => {
        if (error.response && error.response.status !== 404) {
            console.error('Error resetting condition:', error);
            alert('リセット中にエラーが発生しました。');
        }
    });

    hideModal();
}
