# Laravel Simple Blog

## 1. Overview

Build a simple blog system with basic user authentication and post management.

## 2. Workflow

1. Set a deadline and let us know. This deadline will depend on your schedule.
2. Clone this repository and set up the environment.
3. Change the remote repository to your public repository (do not delete the commit history).
4. Implement the required features according to the specifications below.
5. Push your changes to your public repository.

## 3. Requirements

### Homepage

1. Switch content based on login status.
    - **For Authenticated Users**: Show all of their own posts, including drafts and scheduled posts.
    - **For Guest Users**: Show links to the login and registration pages.
2. Show status label in each post.

### Post Pages

1. **Post Visibility**: All users, including guest users, can see the post listing and detail pages.
2. **Post Creation**: Only authenticated users can create new posts.
3. **Post Update/Deletion**: Only the post's author can update and delete their posts.
4. **Post Title**: The length of post titles must be 60 characters or less.
5. **Drafts and Scheduling**: Posts can be saved as drafts or scheduled for future publishing. These posts are hidden on the post listing page and post detail pages.

### Others

1. Follow the "Laravel way" and implement Laravel best practices.
2. Create a post seeder, including all possible statuses.
3. Write HTTP tests for home and posts routes to ensure your application behaves as expected and is reliable.
4. For team development, commit with an appropriate commit size and write suitable commit messages.

## 4. Hints
- You can use any references or tools, such as official documentation, Stack Overflow, ChatGPT, Copilot, and Gemini.
- You can use any AI tools to generate code; however, don't forget to review it by yourself.
- Static view files are already provided in the project.
- You can create a sample user using the seeder.

```
php artisan db:seed
```

Sample User Credentials:

-   Email: `test@example.com`
-   Password: `password`
