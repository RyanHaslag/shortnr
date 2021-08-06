# Shortnr

Shortnr is a Laravel URL-shortener application!

## Installation

Docker must be installed and running. PHP 8, Composer, and NPM are required to run the application.

Rename the .env.example file to .env and update the database credentials to allow for Sail to create a MySQL connection

```bash
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=shortnr
DB_USERNAME=sail
DB_PASSWORD=password
```

Initialize all composer packages required by the project

```bash
composer install
```

Initialize the application by starting Sail

```bash
./vendor/bin/sail up
```

*Optionally create an alias for Sail in your bash or zsh profile

```bash
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

Generate a new app key for the project

```bash
 sail artisan key:generate
```

Migrate all existing database tables

```bash
sail artisan migrate
```

Initialize all frontend required packages from NPM

```bash
sail npm install && npm run dev
```

## Challenges of building the URL Shortener

1. Deciding on an adequate mechanism to determine the shortest available URL. Utilizing the index of the last entry into the URL table provided the ability to introduce a bijective formula to iterate over the available base character set efficiently to generate the short code.

2. Deciding how many edge cases should be handled in the given time period was another challenge. I took the approach of handling what would be the most obvious edge cases that could possibly occur and made sure that they were handled. Specifically the edge case of a user generating a shortcode that already matches an existing route used by the application.

3. Finding an efficient and unobtrusive way of displaying the NSFW modal while still passing the full URL back to the frontend. I opted for passing the full URL to blade and then taking in that full URL as a prop to the Vue component and creating a timeout that would redirect the user through JS.

4. Error-handling in a clean, uniform manner took some effort to ensure that errors could be passed directly to blade files in as close of the same manner as passing errors back to the JS directly.

## Design Decisions

1. The first major design decision was whether to utilize a Vue frontend or going with something less robust such as jQuery. Making a URL shortener doesn't necessarily involve several of the benefits of utilizing a robust JS solution, but it proved to be incredibly beneficial in terms of the speed of development (especially the NSFW bonus portion).

2. Another design decision was how to structure the backend of the project. I opted for creating a service that would handle the actual calculation of the shortest available URL that could be used throughout the application with future development.  I tried to design the backend of the system in a way that would support a more robust feature set.

3. I didn't opt to initially create a full "API" to handle the calls from the frontend. This was purely a decision based on available time to complete the project. With more time, I would definitely consider a more structured solution splitting up the view controllers and a "full-fledged" API.

## Future Improvements

1. The first and most obvious improvement to the application would be to create expirations to the links. Utilizing a base-62 set allows for more available shortcodes than would most likely be necessary, but most links over time would either be forgotten or go completely unused. This would most-likely involve a more robust solution of generating the shortest available URLs as old indexes that had smaller short codes would become available again.

2. The second improvement to be made would be to check if a short code has already been generated for the provided URL. This could likely be an actual application design decision whether multiple users should share the same links or if they should be unique to the user that generated.

3. The third improvement would be an expansion of frontend displays as the user is inputting URL's. It would be really nice to have an indicator when the user is typing to show when they have typed a valid URL as they are typing.

4. The fourth improvement would be to expand the backend structure to support a full API (potentially including moving more logic out of the controller to further develop a repository/service design pattern.

5. The fifth improvement would be to make the application responsive so that it would be better shown on mobile applications (it was primarily built for larger screen sizes).
