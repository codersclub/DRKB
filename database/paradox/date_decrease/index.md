---
Title: Как уменьшить дату в Paradox
Date: 01.01.2007
Source: <https://www.delphifaq.com>
---


Как уменьшить дату в Paradox
============================

В Local SQL для Paradox имеется ошибка, вместо вычитания происходит
сложение даты с константой.

    // Это добавляет единицу!
    UPDATE SAMPLE.DB SET DT = DT - 1

    // а данное выражение даст правильный результат:
    UPDATE SAMPLE.DB SET DT = DT + (-1)

