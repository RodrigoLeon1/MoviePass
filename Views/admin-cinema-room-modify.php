<main>
        <h2 class="dash-title">Modify cinema room</h2>
        <hr>
        <div class="dashboard-container">
            <form class="content-container" action="<?= FRONT_ROOT ?>cinemaRoom/modify" method="post">
                <label>                    
                    <input type="hidden" name="id" value="<?= $cinemaRoom->getId(); ?>">
                </label>
                <label>
                    <h4>Insert name:</h4>
                    <input type="text" name="name" value="<?= $cinemaRoom->getName(); ?>" required>
                </label>                
                <label>
                    <h4>Price for ticket:</h4>
                    <input type="number" name="price" min="1" value="<?= $cinemaRoom->getPrice(); ?>" required>
                </label>
                <label>
                    <h4>Capacity:</h4>
                    <input type="number" name="capacity" min="1" value="<?= $cinemaRoom->getCapacity(); ?>" required>
                </label>                
                <button type="submit" class="btn">Modify</button>
            </form>
        </div>
    </main>

</body>

</html>