var $collectionHolder;

var $addNewAnswer = $('<a href="#" class="btn btn-info">Add new answer</a>')

$(document).ready(function () {

    $collectionHolder = $('#answer_list')

    $collectionHolder.append($addNewAnswer);

    $collectionHolder.data('index', $collectionHolder.find('#answer').length)

    $collectionHolder.find('#answer').each(function () {
        addRemoveButton($(this));
    })

    $addNewAnswer.click(function (e) {
        e.preventDefault();
        addNewForm();
    })

    $('input[type=radio]').change(function() {
        $('input[type=radio]:checked').not(this).prop('checked', false);
    });
});

function addRemoveButton ($answer) {
    var $removeButton = $('<a href="#" class="btn btn-danger" style="margin-bottom: 40px">Remove</a>')

    $removeButton.click(function (e) {
       $(e.target).parents('#answer').slideUp(500, function () {
            $(this).remove()
       })
    });

    $answer.append($removeButton);
}

function addNewForm() {
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');
    var newFrom = prototype;

    newFrom = newFrom.replace(/__name__/g, index);

    $collectionHolder.data('index', index+1);

    var $newAnswer = $('<div id="answer" ></div>');
    $newAnswer.append(newFrom);

    addRemoveButton($newAnswer);

    $addNewAnswer.before($newAnswer);
}
