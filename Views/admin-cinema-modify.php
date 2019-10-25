    <main>
        <h2 class="dash-title">Modify cinema</h2>
        <hr>
        <div class="dashboard-container">
            <form class="content-container" action="<?= FRONT_ROOT ?>cinema/modify" method="post">
                <label>
                    <h4>Id:</h4>
                    <input type="number" name="id" id="" value="<?php echo $cinema->getId(); ?>">
                </label>
                <label>
                    <h4>Insert name:</h4>
                    <input type="text" name="name" id="" value="<?php echo $cinema->getName(); ?>">
                </label>
                <label>
                    <h4>Capacity:</h4>
                    <input type="number" name="capacity" id="" value="<?php echo $cinema->getCapacity(); ?>">
                </label>
                <label>
                    <h4>Address:</h4>
                    <input type="text" name="address" id="" value="<?php echo $cinema->getAddress(); ?>">
                </label>
                <label>
                    <h4>Price for ticket:</h4>
                    <input type="number" name="price" id="" value="<?php echo $cinema->getPrice(); ?>">
                </label>
                <button type="submit">Modify</button>
            </form>

        </div>
    </main>

</body>

</html>
