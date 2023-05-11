| Field        | Type         | Specifications                            | Description                                      |
|--------------|--------------|-------------------------------------------|--------------------------------------------------|
| id           | INT          | PRIMARY KEY, UNSIGNED, NOT NULL, AUTO_INCREMENT | Unique identifier for the task           |
| date         | DATE         | NOT NULL                                  | Task due date                                        |
| name         | VARCHAR(255) | NOT NULL                                  | Task name                                        |
| description  | VARCHAR(500) | NULLABLE                            | Detailed task description                        |
