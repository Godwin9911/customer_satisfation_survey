BEGIN TRANSACTION;

CREATE TABLE surveys (
    id INT NOT NULL AUTO_INCREMENT,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    opening_message TEXT NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE questions (
    id INT NOT NULL AUTO_INCREMENT,
    survey_id INT NOT NULL,
    question TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY (survey_id),
    CONSTRAINT questions_survey_id_foreign
        FOREIGN KEY (survey_id)
            REFERENCES surveys (id)
                ON DELETE CASCADE
);

CREATE TABLE survey_customers (
    id INT NOT NULL AUTO_INCREMENT,
    survey_id INT NOT NULL,
    phone VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY (survey_id),
    CONSTRAINT survey_customers_survey_id_foreign
        FOREIGN KEY (survey_id)
            REFERENCES surveys (id)
                ON DELETE CASCADE
);

CREATE TABLE survey_customers_rating (
    id INT NOT NULL AUTO_INCREMENT,
    survey_id INT NOT NULL,
    question_id INT NOT NULL,
    survey_customers_id INT NOT NULL,
    phone VARCHAR(255) NOT NULL,
    rating INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY (survey_id),
    KEY (question_id),
    KEY (survey_customers_id),
    CONSTRAINT survey_customers_rating_survey_id_foreign
        FOREIGN KEY (survey_id)
            REFERENCES surveys (id)
                ON DELETE CASCADE,
    CONSTRAINT survey_customers_rating_question_id_foreign
        FOREIGN KEY (question_id)
            REFERENCES questions (id)
                ON DELETE CASCADE,
    CONSTRAINT survey_customers_rating_survey_customers_id_foreign
        FOREIGN KEY (survey_customers_id)
            REFERENCES survey_customers (id)
                ON DELETE CASCADE
);

COMMIT;
