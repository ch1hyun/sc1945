function requestFromQuery(query) {
    let querys = query.split('&');

    let addDict = {};
    let temp;
    for (let q of querys) {
        temp = q.split('=');
        addDict[temp[0]] = temp[1];
    }

    let hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');

    let originDict = {};
    for (let h of hashes) {
        temp = h.split('=');
        originDict[temp[0]] = temp[1];
    }

    for (let a in addDict) {
        originDict[a] = addDict[a];
    }

    let urlQuery = '?';
    for (let o in originDict) {
        if (originDict[o] === undefined) continue;
        urlQuery += o + '=' + originDict[o] + '&';
    }

    location.href = urlQuery.slice(0, urlQuery.length - 1);
}

function sSubmit() {
    let temp = $('.edit-schedule');
    let editSchedule = {};
    for (let i = 0; i < temp.length; ++i) {
        let dateFormat =
            $('#current-date').val() +
            '-' +
            temp[i].parentNode.parentNode.parentNode.firstElementChild.innerText;
        let content = temp[i].firstChild.data;

        if (editSchedule[dateFormat] === undefined) {
            editSchedule[dateFormat] = [];
        }

        editSchedule[dateFormat].push(content);
    }

    let scheduleForm = $('<form></form>');

    scheduleForm.attr('method', 'post');
    scheduleForm.attr('action', '/admin/schedule/edit');

    scheduleForm.append(
        $('<input/>', { type: 'hidden', name: 'editSchedule', value: JSON.stringify(editSchedule) })
    );
    scheduleForm.append(
        $('<input/>', { type: 'hidden', name: 'currentDate', value: $('#current-date').val() })
    );

    scheduleForm.appendTo('body');
    scheduleForm.submit();
}