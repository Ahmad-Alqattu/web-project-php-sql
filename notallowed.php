<html>

<head>


    <div class="container">
        <div class="message">
            <h2>Access Denied</h2>
            <p>You do not have access to this system. Please log in to continue.</p>
            <a href="index.php">login</a>
        </div>
    </div>

</html>'
<style>
* {
    margin: 0;
    padding: 0;
}

.container {
    display: flex;
    background-color: #111;

    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.message {
    background-color: #111f3f;
    color: #FF0000;
    padding: 20px;
    border-radius: 10px;
    font-size: 1.5em;
    text-align: center;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>
<?php exit; ?>