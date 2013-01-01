---
Title: Проверка битовых значений
Author: Vit
Date: 01.01.2007
---


Проверка битовых значений
=========================

::: {.date}
01.01.2007
:::

1\. Проверить чтобы одно или более значений битовых полей было 1

    Select * From MyTable Where (MyBitField1 | MyBitField2 | MyBitField3)=1

2\. Проверить чтобы все значения битовых полей были равны 1

    Select * From MyTable Where (MyBitField1 & MyBitField2 & MyBitField3)=1

Автор: Vit
