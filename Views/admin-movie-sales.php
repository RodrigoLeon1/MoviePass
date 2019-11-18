<main>
        <h2 class="dash-title">Movies sales</h2>
        <hr>
        
        <div class="dashboard-container">            
            <div class="content-container">
                <table border="1">
                    <thead>
                        <tr>
                            <th>Poster</th>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Total</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movies as $movie): ?>
                            <tr>  
                                <td>
                                    <img src="<?= IMG_PATH_TMDB . $movie->getPosterPath() ?>" alt="">
                                </td>
                                <td><?= $movie->getId() ?></td>
                                <td><?= $movie->getTitle() ?></td>
                                <td>$<?= $this->movieDAO->getSales($movie) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>