async function checkRun() {
    let status = await getStatus();
    while (status['ongoing'] !== true) {
        if (confirm("Indulhat a játék?")) {
            status = await startGame();
        }
    }
    fillBoard(status);
}

function getStatus() {
    return new Promise(function (resolve, reject) {
        let request = null;
        if (window.XMLHttpRequest) {
            request = new XMLHttpRequest();
        } else if (typeof ActiveXObject != undefined) {
            request = new ActiveXObject('Microsoft.XMLHTTP');
        }
        request.open('get', '/api/game/status', true);
        request.onreadystatechange = function () {
            if (request.readyState === 4) {
                if (request.status === 200) {
                    let response = JSON.parse(request.responseText);
                    resolve(response);
                } else {
                    reject();
                }
            }
        };
        request.send(null);
    });
}

function startGame() {
    return new Promise(function (resolve, reject) {
        let request = null;
        if (window.XMLHttpRequest) {
            request = new XMLHttpRequest();
        } else if (typeof ActiveXObject != undefined) {
            request = new ActiveXObject('Microsoft.XMLHTTP');
        }
        request.open('get', '/api/game/start', true);
        request.onreadystatechange = function () {
            if (request.readyState === 4) {
                if (request.status === 200) {
                    let response = JSON.parse(request.responseText);
                    resolve(response);
                } else {
                    reject();
                }
            }
        };
        request.send(null);
    });
}

function fillBoard(status) {
    $("#actual_score").text(status['current_round']);
    $('#question_text').text(status['question']['text']);
    $('#answers').text('');
    let letter = 'A';
    for (const [key, value] of Object.entries(status['question']['answers'])) {
        let answerNode = $('<div class="answer" data-answer_id="' + key + '"></div>');
        answerNode.html('<span class="answer_letter">' + letter + '</span><span class="answer_text">' + value + '</span><div class="clearfix"></div>');
        $('#answers').append(answerNode);
        letter = nextChar(letter);
    }
    if (status['selected_answer']) {
        $('.answer[data-answer_id="' + status['selected_answer'] + '"]').addClass('selected');
    }
    $(".answer").click(function () {
        select($(this).data('answer_id'));
    });
}

function nextChar(char) {
    return String.fromCharCode(char.charCodeAt(0) + 1);
}

async function select(answer_id) {
    let status = await getStatus();
    if (!status['selected_answer']) {
        $('.answer[data-answer_id="' + answer_id + '"]').addClass('selected');
        let selected = await new Promise(function (resolve, reject) {
            let request = null;
            if (window.XMLHttpRequest) {
                request = new XMLHttpRequest();
            } else if (typeof ActiveXObject != undefined) {
                request = new ActiveXObject('Microsoft.XMLHTTP');
            }
            const params = 'answer_id=' + answer_id;
            request.open('post', '/api/game/select', true);
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            request.onreadystatechange = function () {
                if (request.readyState === 4) {
                    if (request.status === 200) {
                        let response = JSON.parse(request.responseText);
                        resolve(response);
                    } else {
                        reject();
                    }
                }
            };
            request.send(params);
        });
        setTimeout("evaluates(selected)", 3000);
    }
}

function evaluates(){
    console.log('Helyes/Helytelenm válasz kiértékelése');
}

checkRun();