---
Title: Понятие о модели и схеме базы данных
Date: 01.01.2007
---


Понятие о модели и схеме базы данных
====================================

::: {.date}
01.01.2007
:::

Понятие о модели и схеме базы данных

Для каждой конкретной базы данных существует схема базы данных. Схема
базы данных описывает взаимоотношение между данными, структуру отдельных
компонент, правила модификации и взаимозависимость между данными.

В примере про резервирование авиабилетов схема базы данных определяет,
что для каждого рейса в базе данных хранится такая информация, как общее
количество билетов для каждого класса, что каждый рейс характеризуется
временем вылета и продолжительностью роейса и т.д. Именно схема базы
данных определяет, что в базе данных не может быть занесена информация о
двух билетах на одно и тоже место, при удалении рейса из списка также
должны быть аннулированы проданные на этот место билеты и т.д.

Понятие модель данных относится к тем принципам, на основе которых
построена схема базы данных. При разработке баз данных обычно
используются специальные инструментальные программные средства, то есть
СУБД. Так как СУБД, с помощью которой реализована та или иная база
данных, как правило, позволяет использовать вполне определенные принципы
построения схемы базы данных, то понятие модели данных относится и к
СУБД.

Конечно же, если для разработки базы данных использовался язык низкого
уровня типа С/С++, или даже ассемблер, то говорить о том, какая модель
данных поддерживается данным инструментом, бессмысленно. С помощью таких
инструментальных средств можно разработать любую базу данных с любой
моделью данных. Однако использование таких низкоуровневых средств
разработки встречается чрезвычайно редко, так как разработка, отладка и
сопровождение реализованной базы данных будет стоить очень дорого, а
временные затраты будут большими.

Основные задачи и функции

Рассмотрим те задачи, которые должны быть решены при разработке
информационной системы, то есть те функции, которые должна позволять
реализовывать система управления базами данных.

::: {style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 8px 0px 8px 0px;"}
  ---- ----------------------------------------------------------------------------------
  1.   Обеспечивать работу пользователя (оператора) по извлечению и модификации данных.
  ---- ----------------------------------------------------------------------------------
:::

::: {style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 8px 0px 8px 0px;"}
  ---- ---------------------------------------------------------------------------
  2.   Обеспечивать одновременный доступ нескольких пользователей к базе данных.
  ---- ---------------------------------------------------------------------------
:::

::: {style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 8px 0px 8px 0px;"}
  ---- -------------------------------------------------------------------------------------------------------------------------
  3.   Предоставлять возможность выполнения административных действий по поддержанию работоспособности информационной системы.
  ---- -------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 8px 0px 8px 0px;"}
  ---- -----------------------------------------------------------------------------------------------
  4.   Обеспечивать идентификацию и разграничение прав доступа разных пользователей к разным данным;
  ---- -----------------------------------------------------------------------------------------------
:::

::: {style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 8px 0px 8px 0px;"}
  ---- -----------------------------------------------------------------------------------------------
  5.   Обеспечивать целостность и непротиворечивость данных в случае аппаратных и программных сбоев;
  ---- -----------------------------------------------------------------------------------------------
:::

::: {style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 8px 0px 8px 0px;"}
  ---- -------------------------------------------------
  6.   Защищать данные от несакционированного доступа;
  ---- -------------------------------------------------
:::

Рассмотрим эти требования более подробно.

Обеспечивать работу пользователя (оператора) по извлечению и модификации
данных. Вообще говоря, это основная, видимая сторона любой
информационной системы. Механизм реализации этих возможностей может и
должен быть скрыт от пользователя, то есть пользователь просто нажимает
некоторую кнопку (например, "Зарезервировать билет"), а уж как это
реализовано внутри - это должно быть скрыто.

Обеспечивать одновременный доступ нескольких пользователей к базе
данных. При одновременной работе нескольких операторов по резервированию
авиабилетов не должны возникать конфликты типа того, что оба видят на
экране своих терминалов свободное место под номером "4F" и оба
выписывают на него билеты. С другой стороны, недопустима ситуация, когда
один оператор, работая с тем или иным рейсом, делает невозможной работу
других операторов с этим же рейсом.

Предоставлять возможность выполнения административных действий по
поддержанию работоспособности информационной системы. В реальной
информационной системе очень важно обеспечить технологичность, то есть
информационная система позволять добавлять или удалять пользователей,
настраиваться на новые аппаратные ресурсы и т.д.

Обеспечивать идентификацию и разграничение прав доступа разных
пользователей к разным данным. В реальных информационных системах должно
существовать разграничение по правам доступа к данным. Какие-то
пользователи могут и читать и модифицировать данные, какие-то
пользователи могут только читать, а кто-то вообще может только вводить
данные, а читать не имеет право. Например, любой посетитель в аэропорту
может иметь возможность просмотреть список коммерческих рейсов и
количество свободных мест на них. Изменять эти данные он не имеет право,
это должен делать кассир, предварительно получив деньги. Доступ же к
информации по грузовым и заказным рейсам для обычного посетителя вообще
должен быть закрыт.

Обеспечивать целостность и непротиворечивость данных в случае аппаратных
и программных сбоев. Несмотря на то, что за последнее время надежность
аппратной части существенно выросла, абсолютно надежной техники не
бывает. В случае внезапного выключения и последующего включения
компьютера, на котором работает сервер базы данных, информация не должна
быть искажена. Также информационная система должна быть максимально
устойчива к программным ошибкам (или к злому умыслу). Например, следует
исключить возможность выдачи билета на несуществующий рейс. В случае
выхода аппаратуры из строя, должна существовать возможность восстановить
работоспособность системы с минимальными потерями информации.

Защищать данные от несакционированного доступа. В современных
информационных системах все данные, или, по крайней мере, их
значительная часть, является конфиденциальной. Помимо разграничения
доступа для разных категорий пользователей, информационная система
должна обеспечивать защиту от попыток получить доступ к данным тем
лицам, которые не являются пользователями информационной системы.

 

Грачев А.Ю.                Введение в СУБД Informix