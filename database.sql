CREATE TABLE surveys (
    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    title TEXT COLLATE utf8mb4_unicode_ci NOT NULL,
    description TEXT COLLATE utf8mb4_unicode_ci NOT NULL,
    opening_message TEXT COLLATE utf8mb4_unicode_ci NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE questions (
    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    survey_id BIGINT(20) UNSIGNED NOT NULL,
    question TEXT COLLATE utf8mb4_unicode_ci NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id),
    KEY (survey_id),
    CONSTRAINT questions_survey_id_foreign FOREIGN KEY (survey_id) REFERENCES surveys (id) ON DELETE CASCADE
);

CREATE TABLE survey_customers (
    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    survey_id BIGINT(20) UNSIGNED NOT NULL,
    phone VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id),
    KEY (survey_id),
    CONSTRAINT survey_customers_survey_id_foreign FOREIGN KEY (survey_id) REFERENCES surveys (id) ON DELETE CASCADE
);

CREATE TABLE survey_customers_rating (
    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    survey_id BIGINT(20) UNSIGNED NOT NULL,
    question_id BIGINT(20) UNSIGNED NOT NULL,
    survey_customers_id BIGINT(20) UNSIGNED NOT NULL,
    phone VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    rating INT(11) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id),
    KEY (survey_id),
    KEY (question_id),
    KEY (survey_customers_id),
    CONSTRAINT survey_customers_rating_survey_id_foreign FOREIGN KEY (survey_id) REFERENCES surveys (id) ON DELETE CASCADE,
    CONSTRAINT survey_customers_rating_question_id_foreign FOREIGN KEY (question_id) REFERENCES questions (id) ON DELETE CASCADE,
    CONSTRAINT survey_customers_rating_survey_customers_id_foreign FOREIGN KEY (survey_customers_id) REFERENCES survey_customers (id) ON DELETE CASCADE
);

COMMIT;
