    <footer>
        <div class="ft-container">
            <p>Copyright ©2019 All rights reserved</p>
            <p>Designed and developed by x</p>
        </div>
    </footer>

    <script src="<?= LIBS_PATH ?>/Glider/glider.min.js"></script>
    <script>
        new Glider(document.querySelector('.glider'), {
            slidesToShow: 4,
            slidesToScroll: 4,
            draggable: true,
            dots: '#dots',
            arrows: {
                prev: '.glider-prev',
                next: '.glider-next'
            },
            responsive: [
                {
                    // screens greater than >= 775px
                    breakpoint: 775,
                    settings: {
                        // Set to `auto` and provide item width to adjust to viewport
                        slidesToShow: 'auto',
                        slidesToScroll: 'auto',
                        itemWidth: 150,
                        duration: 0.25
                    }
                }, {
                    // screens greater than >= 1024px
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        itemWidth: 150,
                        duration: 0.25
                    }
                }
            ]
        });

        new Glider(document.querySelector('.glider2'), {
            slidesToShow: 4,
            slidesToScroll: 4,
            draggable: true,
            dots: '#dots2',
            arrows: {
                prev: '.glider2-prev',
                next: '.glider2-next'
            },
            responsive: [
                {
                    // screens greater than >= 775px
                    breakpoint: 775,
                    settings: {
                        // Set to `auto` and provide item width to adjust to viewport
                        slidesToShow: 'auto',
                        slidesToScroll: 'auto',
                        itemWidth: 150,
                        duration: 0.25
                    }
                }, {
                    // screens greater than >= 1024px
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        itemWidth: 150,
                        duration: 0.25
                    }
                }
            ]
        })

    </script>

    </body>
</html>