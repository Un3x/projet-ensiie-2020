<div class="card bg-dark">
    <div class="card-body">
        <h1 class="display-4"><i class="fas fa-cube"></i> API Documentation</h1>
        <p class="lead">You want to use <b class="logo"><b class="letter">ST</b>II<b class="letter">M</b>E</b> API? You're at the right place. All routes, methods, parameters are here!</p>
        <h3>Summary</h3>

        <ul class="list-unstyled">
            <li><a href="#introduction" class="text-decoration-none">Introduction</a></li>
            <li><a href="#search" class="text-decoration-none">Search</a>
                <ul class="list-unstyled" style="padding-left: 20px">
                    <li><a href="#s-keyword" class="text-decoration-none">Keyword</a></li>
                    <li><a href="#s-user" class="text-decoration-none">User</a></li>
                    <li><a href="#s-game" class="text-decoration-none">Game</a></li>
                    <li><a href="#s-message" class="text-decoration-none">Message</a></li>
                </ul>
            </li>
        </ul>

        <a class="anchor" id="introduction"></a>
        <h3>Introduction <code>/api</code></h3>
        <p class="card-text">
            If you want use the API, you must use your <b>session token</b>.
        </p>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
            </div>
            <input id="api-key" readonly type="text" class="form-control text-monospace" value="••••••••••••••••••••••••••" onmouseenter="show(this)" onmouseout="hide(this)" onclick="copy(this)">
        </div>

        <div class="card bg-secondary">
            <div class="card-body">
                <pre class="mb-0" style="color: #fff"><code>fetch('http://localhost/api/search?q=' + str)
    .then(response => response.json()).then((data) => {
        for (const element of data) {
            <b>console.log(element)</b>
        }
    })</code></pre>
            </div>
        </div>
        <br />

        <a class="anchor" id="search"></a>
        <h3>Search <code>/api/search</code></h3>
        <a class="anchor" id="s-keyword"></a>
        <h4>Keyword: <code>/api/search/keyword</code> <kbd>GET</kbd></h4>
        <p class="card-text">
            Search all keywords containing <code>query</code> : users, games, hashtags, genres.
        </p>
        <h5>Parameters</h5>
        <p class="card-text"><kbd>q</kbd> query: <code>String</code></p>
        <h5>Response</h5>
        <p class="card-text"><code>Array</code> of <code>String</code>: keywords (users, games, hashtags, genres) containing <kbd>q</kbd> in it.</p>
        <br />

        <h4>User: <code>/api/search/user</code> <kbd>GET</kbd></h4>
        <p class="card-text">
            Search all keywords containing query : users, games, hashtags, genres.
        </p>
        <h5>Parameters</h5>
        <p class="card-text"><kbd>q</kbd> query: <code>String</code></p>
        <br />

        <h4>Game: <code>/api/search/game</code> <kbd>GET</kbd></h4>
        <p class="card-text">
            Search all keywords containing query : users, games, hashtags, genres.
        </p>
        <h5>Parameters</h5>
        <p class="card-text"><kbd>q</kbd> query: <code>String</code></p>
        <br />

        <h4>Message: <code>/api/search/message</code> <kbd>GET</kbd></h4>
        <p class="card-text">
            Search all keywords containing query : users, games, hashtags, genres.
        </p>
        <h5>Parameters</h5>
        <p class="card-text"><kbd>q</kbd> query: <code>String</code></p>
        <br />

    </div>
</div>
<style>
    a.anchor {
        display: block;
        position: relative;
        top: -60px;
        visibility: hidden;
    }
</style>
<script>
    function show(el) {
        el.value = "<?php echo session_id() ?>"
    }

    function hide(el) {
        el.value = "••••••••••••••••••••••••••"
    }

    function copy(el) {
        el.select();
        if (document.execCommand("copy")) el.value = "Copied!";
    }
</script>