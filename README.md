# Camagru
###### Ecole 42 - Initial project of the web path   

A PHP project with the objective of creating an Instagram-like web application.
Built with MVC architecture and PDO.
(Frameworks are not allowed)

## Getting Started

Follow these instructions to get a copy of the project and run it on your local machine for development and testing purposes.

### Prerequisites

```
php 7
mysql
sendmail
```


### Installing
```
git clone 
cd 
php -S localhost:8080
navigate to http://localhost:8080/config/setup.php
navigate to http://localhost:8080/
...
```

## Features

### User Authentication
- Registration with email address, username and password
- Login with username and password
<img alt="Login" src="./readme_img/login.png" width="75%" title="login" border="solid">

### User Area
- Forgotten password reset via email
- Email, username, password and email notification editing
<img alt="user area" src="./readme_img/user_area.png" width="75%" title="user area">


### Home - Camera
- Accessible only to connected users
- Thumbnails of all previous pictures taken
- The creation of the final image, i.e. the superimposition of the two images, takes place on the server side
- Ability to upload an image if webcam access is not available

<img alt="Home" src="./readme_img/home.png" width="75%" title="home">
<img alt="photo" src="./readme_img/photo.png" width="75%" title="photo">


### Gallery
- Public section, with infinite pagination, containing photos of all users, sorted by creation date
- Likes and comments are only available to connected users
<img alt="home" src="./readme_img/gallery.png" width="75%" title="gallery">
<img alt="home" src="./readme_img/gallery2.png" width="75%" title="gallery">


### Mobile Version
<img alt="Home mobile" src="./readme_img/mobile1.png" width="50%" title="Home mobile">
<img alt="Home mobile" src="./readme_img/mobile2.png" width="50%" title="Home mobile">
<img alt="Gallery mobile" src="./readme_img/mobile3.png" width="50%" title="Gallery mobile">


## Built with

* PHP
* MySQL 
* Bulma
* HTML/CSS
* JS
* Ajax
