create database project;

use project;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (post_id) REFERENCES posts(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

insert into users(name, email) values ('ziad', 'ziadomran@gmail.com'), ('test', 'test@test.com'), ('aloooo', 'okokoko@gmail.com');

insert into posts(title,content, user_id) values ('ALOOO', 'this is content, test test tespostst', 1), ('This is a Title', 'Thissssss issssssssss content', 2);

insert into comments (content, post_id, user_id) values ('alooooooooo??????', 1, 1), ('this is a comment, well done my friend', 1, 2), ('COMMENT 12 3  323', 2,3);

select * from comments;
