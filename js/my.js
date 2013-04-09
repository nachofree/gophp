(function(){
    var editor;
    
    var updateStatusBar = function(e) {
        var cursor_position = editor.getCursorPosition();
        $('.statusbar .position').text('Line: ' + (1+cursor_position.row) + ', Column: ' + cursor_position.column);
    };

    var initializeAce = function(){
        var PhpMode;
        editor = ace.edit("editor");
    
        PhpMode = require("ace/mode/php").Mode;
        editor.getSession().setMode(new PhpMode());
        editor.getSession().setTabSize(4);
        editor.getSession().setUseSoftTabs(true);
        editor.getSession().selection.on('changeCursor', updateStatusBar);
        
        
        //bind the submit command to a key
        editor.commands.addCommand({
            name: 'keySubmit',
            bindKey: {
                win: 'Ctrl-M',
                mac: 'Ctrl-M'
            },
            exec: handleSubmit
        });
        
        //bind the clear command to a key
        editor.commands.addCommand({
            name: 'keyClear',
            bindKey: {
                win: 'Ctrl-k',
                mac: 'Ctrl-k'
            },
            exec: initializeAce
        });

    }
    
    var clear = function(){
        $('#editor').replaceWith('<div id="editor" class="editor"></div>');
        initializeAce();
    }
    
    var handleSubmit = function(e){
        e.preventDefault();
        $('div.output2').html('<img src="./images/loader.gif" class="loader" alt="" /> Loading ...');
        $.post('./ajaxQuery.php?js=1', {
            /*see header.php for JSON representation*/
            //            question: myString,
            questionID: document.getElementById('codeID').value,
            code: editor.getSession().getValue()
        }, function(res) {
            //alert(res);
            //parsing issues??
            //alert(s);
            var s = JSON.parse(res);
            //            //put response in appropriate output locations.
            $('div.output2').html(s.messages);
            $('div.results').html(s.scriptResults);
        });
    }
    
    var handleSave = function(e){
        e.preventDefault();
        $('div.output2').html('<img src="./images/loader.gif" class="loader" alt="" /> Loading ...');
        $.post('./ajaxSave.php?js=1', {
            /*see header.php for JSON representation*/
            //            question: myString,
            questionText: document.getElementById('txtQuestionText').value,
            questionName: document.getElementById('txtQuestionName').value,
            questionType: document.getElementById('select_type').value,
            code: editor.getSession().getValue()
        }, function(res) {
            //parsing issues??
            //alert(s);
            var s = JSON.parse(res);
            //            //put response in appropriate output locations.
            $('div.output2').html(s.messages);
            $('div.results').html(s.scriptResults);
        });
    }

    //load the edtor when document loads
    $(document).ready(function(){
        //alert(addingQuestion);
        initializeAce();
        $('#btnAceClear').click(clear);

        if(!addingQuestion)
        {
            //handle events
            $('#btnAceSubmit').click(handleSubmit);
        }
        else
        {
            //we need to change the page a bit when we are adding questions
            $('#btnAceSubmit').attr('value', 'Save');
            $('#btnAceSubmit').click(handleSave);
            $('#spanQuestionText').html("<textarea rows='10' cols='40' id='txtQuestionText' />");
            $('#spanQuestionName').html("<input type='text' class='input' id='txtQuestionName' />");
            $('#spanQuestionType').html(typeSelect);
        //alert($('#spanQuestionText').text());

        }
    });


    
}());