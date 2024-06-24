---
Title: 14. Отладка
Date: 12.12.2006
Author: Анатолий Подгорецкий
---


14\. Отладка
============

Статья [Indy in depth. Глубины Indy](./)

**Indy.  
Taming Internet development one protocol at a time.**

Copyright Atozed Software

Indy is Copyright (c) 1993 - 2002, Chad Z. Hower (Kudzu)  
and the Indy Pit Crew - <https://www.nevrona.com/Indy/>

&copy; Анатолий Подгорецкий, 2006, перевод на русский язык

 



Обычно отладка клиентов проще отладки серверов. Клиенты просто должны
обслуживать только одно соединение и могут обычно быть отлажены с
помощью простой техники отладки. В данной главе приводится несколько
полезных советов для отладки клиентов и серверов.

### 14.1. Ведение логов

Реально простой путь - что увидеть, что делает клиент, без трассировки
по коду - это использовать классы TIdLogDebug или TIdLogFile. Класс
TIdLogDebug выводит информацию в напрямую в окно отладки и очень удобен
для наблюдения, того, что клиент посылает и принимает в реальном
масштабе времени. Если вы не желает смотреть трафик в реальном времени,
то воспользуйтесь классом TIdLogFile. После того как клиент закончит
свою работу, вы можете посмотреть содержимое файла и увидеть, что
делалось во время сессии.

### 14.2. Симуляция

Но иногда требуется симулировать клиента или сервер, если он не
доступен. Это может быть сделано по причинам безопасности, трафика или
по другим причинам. В таких случаях вы можете воспользоваться
симуляцией. Симуляция может также использоваться для построения клиента,
до построения сервера или для создания тестовых скриптов, путем
симуляции клиента.

Симуляция может быть выполнена с помощью TIdIOHandlerStream и назначения
потока вывода в текстовый файл, поток ввода должен быть установлен в
nil. Это указывает классу TIdIOHandlerStream читать все данные для
посылки клиенту из текстового файла и игнорировать все данные
возвращаемые с клиента.

Если вы назначите поток ввода, то будет происходить ведение лога с
данными клиента.

### 14.3. Запись и воспроизведение

Одним из полезных методов является запись сессии, и последующего ее
воспроизведения. Это особо востребовано для регрессивного тестирования и
удаленной отладки. Если ваш заказчик находится в удаленном месте, то вы
можете послать ему особую версию программы или включить запись сессии.
Затем они могут вам переслать записанный файл, и вы сможете симулировать
его сессию клиента или сервер у себя на месте, без необходимости иметь
реальное соединение с их сервером.

Для выполнения этого используйте класс TIdLogStream для записи принятых
данных в файл. Вы сможете также записать данные, которые клиент
передавал в отдельный файл, но вы не нуждаетесь в этом, пока не
потребуется их посмотреть вручную. После того, как вы получите файл, вы
можете его подсоединить к компоненту TIdIOHandlerStream.

Обработчики ввода/вывода (IOHandlers) также имеют другое полезное
применение. Они используются для записи и воспроизведения. Живая сессия
может быть записана с помощью компонентов ведения логов и позже
воспроизведена с помощью потоков обработчиков ввода/вывода. Представим,
что вы имеет заказчика, у которого есть проблемы, но вы не можете
воспроизвести эти проблемы у себя и не можете посетить его. Вы можете
попросить его прислать лог полной сессии и попытаться воспроизвести
сессию на вашей машине. Команда Indy использует это как часть своей QA
отладки. Я планирую описать это позже.