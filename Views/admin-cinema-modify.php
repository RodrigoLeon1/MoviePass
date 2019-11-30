    <main>
        <h2 class="dash-title">Modify cinema</h2>
        <hr>
        <div class="dashboard-container">
            <form class="content-container" action="<?= FRONT_ROOT ?>cinema/modify" method="post">
                <label>                    
                    <input type="hidden" name="id" value="<?= $cinema->getId(); ?>">
                </label>
                <label>
                    <h4>Insert name:</h4>
                    <input type="text" name="name" value="<?= $cinema->getName(); ?>">
                </label>                
                <label>
                    <h4>Address:</h4>
                    <input type="text" name="address" value="<?= $cinema->getAddress(); ?>">
                </label>                
                <button type="submit" class="btn">Modify</button>
            </form>
        </div>
    </main>

</body>

</html>
