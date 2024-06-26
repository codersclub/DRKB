---
Title: Как корректно прервать выполнение SQL-запроса?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как корректно прервать выполнение SQL-запроса?
==============================================

>Дает ли Delphi возможность корректно прервать выполнение SQL-запроса к
>серверу Oracle с помощью BDE? Например, чтобы при использовании с SQL
>Plus после отправки SQL-запроса на выполнение на экране появлялось окно
>с кнопкой Cancel, которое давало бы возможность в любой момент прервать
>выполнение этого запроса?

Насколько мне известно, для этой цели лучше всего использовать функции
Oracle Call Interface (низкоуровневый API Oracle). В комплекте поставки
Oracle есть соответствующие примеры для C, и переписать их на Pascal
несложно.

Некоторые драйверы SQL Link позволяют прекратить выполнение запроса,
если время его выполнения превышает заранее заданное значение (параметр
MAX QUERY TIME соответствующего драйвера). Однако драйвер ORACLE, к
сожалению, в их число не входит.

