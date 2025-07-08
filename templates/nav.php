 <!-- Navigation -->
        <nav>
        <ul>
            <li><a href="#home" class="active">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#conntact">Contact</a></li>
        </ul>
    </nav>

            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
        });
        </script>

         <link rel="stylesheet" href="CSS/nav.css">