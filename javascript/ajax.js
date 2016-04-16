function ajaxUpdateDB() {
    jQuery.ajax({
        url: './php/reports.php',
        type: 'POST',
        dataType: 'json',
        data: {
            request: 'update'
        },
        complete: function(xhr, textStatus) {},
        success: function(data, textStatus, xhr) {
            $("#balance").empty();
            $("#balance").append("Balance:" + data.balance);
            if (data.winnings > 0) {
                $("#overlay-dialog").html("Congrats! You just won <br/>$" + data.winnings + "<br/><a href='#' onclick='overlay()'>close</a>");
                overlay();
            } else if (data.winnings < 0) {
                $("#overlay-dialog").html("Sorry! You didnt win your bet.<br/><a href='#' onclick='overlay()'>close</a>");
                overlay();
            }
            // else{
            // 	$("#overlay-dialog").html("The game ended in a tie,<br/>you received your initial bet back.<br/><a href='#' onclick='overlay()'>close</a>");
            //     overlay();
            // }
        },
        error: function(xhr, textStatus, errorThrown) {
            console.log(textStatus);
            console.log(errorThrown);
        }
    });

}

function ajaxHomeBetList() {
    jQuery.ajax({
        url: './php/reports.php',
        type: 'POST',
        dataType: 'html',
        data: {
            request: 'homeBetList'
        },
        success: function(data, textStatus, xhr) {
            $("#betlist").empty();
            $("#betlist").append(data.toString());
        },
    });
}

function ajaxHomeBetSidebar() {
    jQuery.ajax({
        url: './php/reports.php',
        type: 'POST',
        dataType: 'html',
        data: {
            request: 'betsSidebar'
        },
        success: function(data, textStatus, xhr) {
            $("#bets").empty();
            $("#bets").append(data.toString());
        },
    });
}

function ajaxSidebar() {
    jQuery.ajax({
        url: './php/sidebar.php',
        type: 'POST',
        dataType: 'html',
        complete: function(xhr, textStatus) {
            //called when complete
        },
        success: function(data, textStatus, xhr) {
            $(".sidebar").empty();
            $(".sidebar").append(data.toString());
        },
        error: function(xhr, textStatus, errorThrown) {
            //called when there is an error
        }
    });
}

function ajaxGames(cat) {
    jQuery.ajax({
        url: './php/reports.php',
        type: 'POST',
        dataType: 'html',
        data: {
            request: 'fillGamesTable',
            category: cat
        },
        success: function(data, textStatus, xhr) {
            $("#fillGames").empty();
            $("#fillGames").append(data.toString());
        }
    });
}

function ajaxBetTable(gameID) {
    jQuery.ajax({
        url: './php/reports.php',
        type: 'POST',
        dataType: 'html',
        data: {
            request: 'fillBetTable',
            id: gameID
        },
        success: function(data, textStatus, xhr) {
            $("#bets_table").empty();
            $("#bets_table").append(data.toString());
        }
    });
}

function ajaxUserTable(){
	jQuery.ajax({
        url: './php/reports.php',
        type: 'POST',
        dataType: 'html',
        data: {
            request: 'fillUserList'
        },
        complete: function(xhr, textStatus) {
            //called when complete
        },
        success: function(data, textStatus, xhr) {
            $("#userList").empty();
            $("#userList").append(data.toString());
        },
        error: function(xhr, textStatus, errorThrown) {
            //called when there is an error
        }
    });
}

function overlay() {
    el = document.getElementById("overlay");
    el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
}


//These are the on page ready function calls
function CommonAjax() {
    ajaxSidebar();
    ajaxUpdateDB();
    setInterval(ajaxSidebar, 10000);
    setInterval(ajaxUpdateDB, 10000);
}

function HomeAjax() {
    CommonAjax();
    ajaxHomeBetList();
    ajaxHomeBetSidebar();
    setInterval(ajaxHomeBetList, 10000);
    setInterval(ajaxHomeBetSidebar, 10000);
}

function GamesAjax(category) {
    CommonAjax();
    ajaxGames(category);
    setInterval(ajaxGames, 10000);
}

function UsermgmtAjax() {
    CommonAjax();
    ajaxUserTable();
}
