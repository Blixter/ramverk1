--
-- Creating a sample table.
--



--
-- Table Book
--
DROP TABLE IF EXISTS Book;
CREATE TABLE Book (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "author" TEXT NOT NULL,
    "title" TEXT NOT NULL,
    "cover" TEXT NOT NULL,
    "genre" TEXT NOT NULL,
    "published" TEXT NOT NULL,
    "totalPages" TEXT NOT NULL
);
