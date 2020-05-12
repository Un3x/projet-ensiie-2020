<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand logo" href="/"><img src="/img/logo.png" height="30" class="d-inline-block align-top" alt="Logo"> <b class="letter">ST</b>II<b class="letter">M</b>E</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/"><i class="fas fa-home"></i>
                    <div class="nav-text">Home</div>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="timeline"><i class="fas fa-stream"></i>
                    <div class="nav-text">Timeline</div>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="users"><i class="fas fa-users"></i>
                    <div class="nav-text">Community</div>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="games"><i class="fas fa-gamepad"></i>
                    <div class="nav-text">Games</div>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="doc-api"><i class="fas fa-cube"></i>
                    <div class="nav-text">API</div>
                </a>
            </li>
            <?php if ($_SESSION["role"] != "member") { ?>
                <li class="nav-item">
                    <a class="nav-link" href="admin"><i class="fas fa-cog"></i>
                        <div class="nav-text">Admin</div>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <form class="form-inline my-2 my-lg-0" action="search" method="get">
            <div class="input-group">
                <input type="text" class="form-control" id="typeahead" placeholder="Search" aria-label="Search" name="q" required>
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <a href="/logout" class="btn btn-outline-light mx-2" role="button"><i class="fas fa-power-off"></i></a>
        <a class="nav-avatar" href="/user?id=<?php echo $_SESSION["id"] ?>">
            <img class="avatar" src="img/user/<?php echo $_SESSION["id"] ?>.png" />
        </a>
    </div>
</nav>

<style>
    .bg-stiime {
        background: linear-gradient(to top, #000, #111D2D) !important;
    }

    .navbar-brand img {
        margin-left: -15px;
    }

    .nav-link .nav-text {
        display: inline-flex;
    }

    @media (min-width:992px) {
        .nav-link .nav-text {
            width: 0;
            overflow: hidden;
            transition: .3s;
        }

        .nav-link:hover .nav-text {
            width: 80px;
        }
    }

    .navbar-nav .nav-link {
        padding: .5rem 1rem;
    }

    .nav-avatar:hover .avatar {
        box-shadow: -4px 4px 15px #6020a080, 4px -4px 15px #00e7a980;
        transition: .3s;
    }

    .nav-item {
        border-radius: 20px .25rem;
        font-weight: 300;
    }

    .nav-item:hover {
        background: #fff2;
    }
</style>
<script>
    // Instantiate the Bloodhound suggestion engine
    var search = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            wildcard: '%QUERY',
            url: '/api/search?q=%QUERY',
            transform: function(response) {
                return response.sort(function(a, b) {
                    if (a.value > b.value) {
                        return 1;
                    }
                    if (b.value > a.value) {
                        return -1;
                    }
                    return 0;
                });
            }
        }
    });

    // Instantiate the Typeahead UI
    $('#typeahead').typeahead({
        hint: true,
        highlight: true,
        minLength: 0
    }, {
        display: 'value',
        source: search,
        limit: 10,
        templates: {
            empty: '<div class="tt-text">No suggestion</div>',
            suggestion: function(data) {
                let type = "";
                switch (data.type) {
                    case "user":
                        type = '<img draggable="false" class="emoji" alt="👤" src="https://twemoji.maxcdn.com/v/12.1.5/72x72/1f464.png"> ';
                        break;
                    case "game":
                        type = '<img draggable="false" class="emoji" alt="🎮" src="https://twemoji.maxcdn.com/v/12.1.5/72x72/1f3ae.png"> ';
                        break;
                    case "hashtag":
                        type = "#";
                        break;
                }
                return `<div class="tt-text">${type}${data.value}</div>`
            }
        }
    });
</script>