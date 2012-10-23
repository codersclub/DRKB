<h1>Руководство по Btrieve</h1>
<div class="date">01.01.2007</div>


<p>ВВЕДЕНИЕ В BTRIEVE</p>
<p>Btrieve - законченная система управления записями, обеспечивающая Вас необходимыми функциями для хранения, поиска и корректировки данных в Ваших файлах баз данных. Благодаря новым методам и структурам Btrieve Вы можете игнорировать физическую структуру файлов, поддержку индексов и проблемы параллелизма и сосредоточиться на логических аспектах Ваших файлов и баз данных.</p>
<p>Для доступа к Btrieve Вы включаете обращения к специфическим функциям в Вашей программе, посылая Btrieve информацию, необходимую для выполнения требуемой операции. Т.к. соглашения по обращению к программам различны для разных языков высокого уровня и компиляторов, в Btrieve включены интерфейсные программы для многих наиболее популярных языков и компиляторв, включая следующие:</p>
<p>  * Microsoft QuickBASIC, IBM интерпретатор и компилятор BASIC-а, Turbo Basic и некоторые другие компиляторы BASIC-а</p>
<p>  * IBM (или Microsoft) Pascal, Turbo Pascal и некоторые другие компиляторы Паскаля</p>
<p>  * Microsoft C, Lattice C, Turbo C и некоторые другие компиляторы C</p>
<p>  * Microsoft COBOL, Realia COBOL, MicroFocus COBOL и некоторые другие компиляторы COBOL-а</p>
<p>Это руководство содержит документацию и примеры программ для BASIC, C, Pascal и COBOL. Документация и дополнительные интерфейсные программы для других языков и компиляторов находятся на дискете Btrieve. Глава 4 включает информацию о требованиях для программ, написанных на ассемблере, для обращения к Btrieve из языков, для которых интерфейс не поддерживается.</p>
<p>ВОЗМОЖНОСТИ BTRIEVE</p>
<p>В следующих разделах приведены некоторые из возможностей, делающих Btrieve уникальной мощной системой управления записями.</p>
<p>ПОДДЕРЖКА ИНДЕКСОВ</p>
<p>Btrieve автоматически создает и поддерживает индексы в Ваших файлах при добавлении, корректировке и удалении записей. Кроме автоматической поддержки индексов Btrieve обеспечивает поддержку индексов в следующих случаях:</p>
<p>  * поддержка до 24 индексов на файл</p>
<p>  * поддержка для добавления или отбрасывания дополнительных индексов после создания файла</p>
<p>  * поддержка до 14 различных типов данных для значений ключей</p>
<p>  * поддержка дублированных, измененных, сегментированных, пустых, ручных и убывающих значенийй ключей</p>
<p>Глава 2 содержит более детальную информацию о том, как использовать индексные признаки Btrieve в Вашей прикладной программе.</p>
<p>СПЕЦИФИКАЦИИ ФАЙЛА</p>
<p>Btrieve позволяет Вам создавать файлы данных, используя обращения к функциям из Вашей прикладной программы или используя внешние утилиты (BUTIL). На уровне файлов Btrieve предлагает Вам следующие возможности:</p>
<p>  * Размеры файла до 4 миллионов байт</p>
<p>  * Неограниченное число записей</p>
<p>  * Способность размещать файл на двух устройствах хранения информации</p>
<p>  * Согласованное определение файлов и управляющих программ</p>
<p>  * Согласованные структуры файлов</p>
<p>УПРАВЛЕНИЕ ПАМЯТЬЮ</p>
<p>Btrieve позволяет Вам задать объем памяти, используемой кэш-буфером ввода/вывода, основываясь на требуемой для Вашей прикладной программы памяти и общим объемом памяти, инсталированным на Вашем сервере. Объем памяти, зарезервированный Вами для кэш-буфера ввода/вывода, может оказать эффект на выполнение Btrieve.</p>
<p>УПРАВЛЕНИЕ ПАРАЛЛЕЛИЗМОМ И ЗАЩИТОЙ</p>
<p>Btrieve обеспечивает возможность управления параллелизмом и защитой данных в сети. Btrieve поддерживает сохранность и защиту данных, позволяя Вам:</p>
<p>  * Задать захват одной или множества записей</p>
<p>  * Захватить файл данных</p>
<p>  * Определить логические транзакции</p>
<p>  * Присвоить имена пользователей файлам</p>
<p>  * Задать динамическую шифровку и расшифровку данных</p>
<p>Глава 2 содержит дополнительную информацию о том, как Btrieve и Ваша прикладная задача обрабатывают параллелизм и защиту.</p>
<p>СОХРАННОСТЬ ДАННЫХ</p>
<p>Btrieve использует некоторые методы для обеспечения сохранности Ваших файлов данных. Эти методы включают:</p>
<p>  * Использование прообразов файлов для хранения образов страниц файла перед добавлением, корректировкой и удалением записей;</p>
<p>  * Использование процесса транзакций для поддержки совместимости между файлами данных во время неоднократной корректировки файла.</p>
<p>BTRIEVE УТИЛИТЫ</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve включает две программы-утилиты так же, как и некоторые</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; диалоговые команды, позволяющие Вам выполнять тестирование и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; управление данными без составления прикладной программы. Они</p>
<p>включают:</p>
<p>  * BUTIL.EXE, утилиту командной строки, позволяющую Вам создавать и управлять файлами данных Btrieve.</p>
<p>  * B.EXE, интерактивную программу-утилиту, которую можно использовать для инструктажа, тестирования и отладки логики Вашей прикладной программы.</p>
<p>  * Диалоговые команды, позволяющие Вам управлять работой сети Btrieve при Вашей работе с сетью.</p>
<p>Смотрите главу 4 для дополнительной информации об утилитах Btrieve и диалоговых командах.</p>
<p>ОПЕРАЦИИ УПРАВЛЕНИЯ ЗАПИСЯМИ</p>
<p>Btrieve поддерживает 36 отдельных операций, которые Вы можете выполнять в Вашей прикладной программе. Для выполнения Btrieve-операции Ваша прикладная задача должна выполнить следующие задачи:</p>
<p>  * Удовлетворять всем требованиям операции.</p>
<p>Например, до выполнения Вашей прикладной задачей ввода/вывода файла она должна сделать файл доступным с помощью выполнения Btrieve-операции Открыть (Open) для этого файла.</p>
<p>  * Инициализировать параметры, требуемые этой операцией.</p>
<p>Параметры - это переменные программы или структуры данных, по типу и размеру соответствующие значениям ожидаемым Btrieve для данной операции.</p>
<p>  * Выполнить обращение к Btrieve-функции (BTRV)</p>
<p>Точный формат обращения к Btrieve-функции изменяется от языка к языку</p>
<p>  * Проверить результаты обращения к функции.</p>
<p>Btrieve всегда возвращает статусный код, ознчающий успех (статус=0) или неудачу (статус&lt;&gt;0) операции. Ваша прикладная задача должна всегда проверять ненулевые статусные коды и предпринимать соответствующие действия.</p>
<p>Кроме того, Btrieve возвращает данные или другую информацию в индивидуальных параметрах, основываясь на цели операции.</p>
<p>Таблица 1.1 перечисляет Btrieve-операции и коды операций и содержит краткое описание выполняемой операцией функции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Таблица 1.1 (Операции Btrieve)</p>
<p>  &nbsp; &nbsp;---------------------------------------------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp;ОПЕРАЦИЯ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;КОД &nbsp; &nbsp;ОПИСАНИЕ</p>
<p>  &nbsp; &nbsp;---------------------------------------------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp;Открыть &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;0 &nbsp; &nbsp; &nbsp; Делает файл доступным</p>
<p>  &nbsp; &nbsp; &nbsp;(Open)</p>
<p>  &nbsp; &nbsp; &nbsp;Закрыть &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1 &nbsp; &nbsp; &nbsp; Отменяет доступ к файлу</p>
<p>  &nbsp; &nbsp; &nbsp;(Close)</p>
<p>  &nbsp; &nbsp; &nbsp;Вставить &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2 &nbsp; &nbsp; &nbsp; Вставляет новые записи в файл</p>
<p>  &nbsp; &nbsp; &nbsp;(Insert)</p>
<p>  &nbsp; &nbsp; &nbsp;Изменить &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 3 &nbsp; &nbsp; &nbsp; Изменяет текущую запись</p>
<p>  &nbsp; &nbsp; &nbsp;(Update)</p>
<p>  &nbsp; &nbsp; &nbsp;Удалить &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;4 &nbsp; &nbsp; &nbsp; Удаляет текущую запись из</p>
<p>  &nbsp; &nbsp; &nbsp;(Delete) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; файла</p>
<p>  &nbsp; &nbsp; &nbsp;Получить Равную &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;5 &nbsp; &nbsp; &nbsp; Получает запись со значением</p>
<p>  &nbsp; &nbsp; &nbsp;(Get Equal) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ключа равным требуемому</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; значению ключа</p>
<p>  &nbsp; &nbsp; &nbsp;Получить Следующую &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 6 &nbsp; &nbsp; &nbsp; Получает запись следующую за</p>
<p>  &nbsp; &nbsp; &nbsp;(Get Next) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; текущей записью в индексном пути</p>
<p>  &nbsp; &nbsp; &nbsp;Получить Предыдущую &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;7 &nbsp; &nbsp; &nbsp; Получает запись предшествующую</p>
<p>  &nbsp; &nbsp; &nbsp;(Get Previous) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; текущей записи в индексном пути</p>
<p>  &nbsp; &nbsp; &nbsp;Получить Большую &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 8 &nbsp; &nbsp; &nbsp; Получает запись со значением</p>
<p>  &nbsp; &nbsp; &nbsp;(Get Greater) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ключа большим требуемого</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; значения ключа</p>
<p>  &nbsp; &nbsp; &nbsp;Получить Большую или &nbsp; &nbsp; &nbsp; &nbsp; 9 &nbsp; &nbsp; &nbsp; Получает запись со значением</p>
<p>  &nbsp; &nbsp; &nbsp; Равную &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ключа равным или большим</p>
<p>  &nbsp; &nbsp; &nbsp;(Get Greater or Equal) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; требуемого значения ключа</p>
<p>  &nbsp; &nbsp; &nbsp;Получить Меньшую Чем &nbsp; &nbsp; &nbsp; &nbsp;10 &nbsp; &nbsp; &nbsp; Получает запись со значением</p>
<p>  &nbsp; &nbsp; &nbsp;(Get Less Than) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ключа меньшим требуем</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; значения ключа</p>
<p>  &nbsp; &nbsp; &nbsp;Получить Меньшую Чем &nbsp; &nbsp; &nbsp; &nbsp;11 &nbsp; &nbsp; &nbsp; Получает запись со значением</p>
<p>  &nbsp; &nbsp; &nbsp;или Равную &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ключа равным или меньшим</p>
<p>  &nbsp; &nbsp; &nbsp;(Get Less Than or Equal) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; требуемого значения ключа</p>
<p>  &nbsp; &nbsp; &nbsp;Получить Первую &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 12 &nbsp; &nbsp; &nbsp; Получает первую запись в</p>
<p>  &nbsp; &nbsp; &nbsp;(Get First) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;запрошенном пути доступа</p>
<p>  &nbsp; &nbsp; &nbsp;Получить Последнюю &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;13 &nbsp; &nbsp; &nbsp; Получает последнюю запись в</p>
<p>  &nbsp; &nbsp; &nbsp;(Get Last) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; запрошенном пути доступа</p>
<p>  &nbsp; &nbsp; &nbsp;Создать &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 14 &nbsp; &nbsp; &nbsp; Создает Btrieve-файл с</p>
<p>  &nbsp; &nbsp; &nbsp;(Create) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; заданными характеристиками</p>
<p>  &nbsp; &nbsp; &nbsp;Статистика &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;15 &nbsp; &nbsp; &nbsp; Возвращает характеристики файла</p>
<p>  &nbsp; &nbsp; &nbsp;(Stat) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; и индекса и число записей</p>
<p>  &nbsp; &nbsp; &nbsp;Расширить &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 16 &nbsp; &nbsp; &nbsp; Расширяет файл на два дисковых</p>
<p>  &nbsp; &nbsp; &nbsp;(Extend) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; тома</p>
<p>  &nbsp; &nbsp; &nbsp;Установить Директорию &nbsp; &nbsp; &nbsp; 17 &nbsp; &nbsp; &nbsp; Изменяет текущую директорию</p>
<p>  &nbsp; &nbsp; &nbsp;(Set Directory)</p>
<p>  &nbsp; &nbsp; &nbsp;Получить Директорию &nbsp; &nbsp; &nbsp; &nbsp; 18 &nbsp; &nbsp; &nbsp; Возвращает текущую директорию</p>
<p>  &nbsp; &nbsp; &nbsp;(Get Directory)</p>
<p>  &nbsp; &nbsp; &nbsp;Начать Транзакцию &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 19 &nbsp; &nbsp; &nbsp; Отмечает начало набора логически</p>
<p>  &nbsp; &nbsp; &nbsp;(Begin Transaction) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;связанных операций</p>
<p>  &nbsp; &nbsp; &nbsp;Закончить Транзакцию &nbsp; &nbsp; &nbsp; &nbsp;20 &nbsp; &nbsp; &nbsp; Отмечает конец набора логически</p>
<p>  &nbsp; &nbsp; &nbsp;(End Transaction) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;связанных операций</p>
<p>  &nbsp; &nbsp; &nbsp;Снять Транзакцию &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;21 &nbsp; &nbsp; &nbsp; Удаляет операции выполненные</p>
<p>  &nbsp; &nbsp; &nbsp;(Abort Transaction) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;во время незавершенной</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; транзакции</p>
<p>  &nbsp; &nbsp; &nbsp;Получить Позицию &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;22 &nbsp; &nbsp; &nbsp; Получает позицию текущей записи</p>
<p>  &nbsp; &nbsp; &nbsp;(Get Position)</p>
<p>  &nbsp; &nbsp; &nbsp;Получить Направление &nbsp; &nbsp; &nbsp; &nbsp;23 &nbsp; &nbsp; &nbsp; Получает запись в заданной</p>
<p>  &nbsp; &nbsp; &nbsp;(Get Direct) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; позиции</p>
<p>  &nbsp; &nbsp; &nbsp;Шаг на Следующую &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;24 &nbsp; &nbsp; &nbsp; Получает запись физически</p>
<p>  &nbsp; &nbsp; &nbsp;(Step Next) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;следующую за текущей записью</p>
<p>  &nbsp; &nbsp; &nbsp;Остановить &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;25 &nbsp; &nbsp; &nbsp; Завершает резидентные в памяти</p>
<p>  &nbsp; &nbsp; &nbsp;(Stop) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; программы Администратора Записей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (Record Manager) на рабочей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; станции</p>
<p>  &nbsp; &nbsp; &nbsp;Версия &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;26 &nbsp; &nbsp; &nbsp; Возвращает загруженную в</p>
<p>  &nbsp; &nbsp; &nbsp;(Version) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;текущее время версию Record</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Manager</p>
<p>  &nbsp; &nbsp; &nbsp;Отмена Захвата &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;27 &nbsp; &nbsp; &nbsp; Отменяет захват записи или</p>
<p>  &nbsp; &nbsp; &nbsp;(Unlock) записей &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; записей</p>
<p>  &nbsp; &nbsp; &nbsp;Сброс &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 28 &nbsp; &nbsp; &nbsp; Освобождает все ресурсы, взятые</p>
<p>  &nbsp; &nbsp; &nbsp;(Reset) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;рабочей станцией</p>
<p>  &nbsp; &nbsp; &nbsp;Установить Владельца &nbsp; &nbsp; &nbsp; &nbsp;29 &nbsp; &nbsp; &nbsp; Присваивает файлу имя владельца</p>
<p>  &nbsp; &nbsp; &nbsp;(Set Owner)</p>
<p>  &nbsp; &nbsp; &nbsp;Стереть Владельца &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 30 &nbsp; &nbsp; &nbsp; Убирает имя владельца из файла</p>
<p>  &nbsp; &nbsp; &nbsp;(Clear Owner)</p>
<p>  &nbsp; &nbsp; &nbsp;Создать Дополнительный &nbsp; &nbsp; &nbsp;31 &nbsp; &nbsp; &nbsp; Создает дополнительный индекс</p>
<p>  &nbsp; &nbsp; &nbsp;Индекс</p>
<p>  &nbsp; &nbsp; &nbsp;(Create Supplemental Index)</p>
<p>  &nbsp; &nbsp; &nbsp;Отбросить Дополнительный &nbsp; &nbsp;32 &nbsp; &nbsp; &nbsp; Убирает дополнительный индекс</p>
<p>  &nbsp; &nbsp; &nbsp;Индекс</p>
<p>  &nbsp; &nbsp; &nbsp;(Drop Supplemental Index)</p>
<p>  &nbsp; &nbsp; &nbsp;Шаг на Первую &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 33 &nbsp; &nbsp; &nbsp; Возвращает запись физически</p>
<p>  &nbsp; &nbsp; &nbsp;(Step First) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; первую в файле</p>
<p>  &nbsp; &nbsp; &nbsp;Шаг на последнюю &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;34 &nbsp; &nbsp; &nbsp; Возвращает запись физически</p>
<p>  &nbsp; &nbsp; &nbsp;(Step Last) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;последнюю в файле</p>
<p>  &nbsp; &nbsp; &nbsp;Шаг на Предыдущую &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 35 &nbsp; &nbsp; &nbsp; Получает запись физически</p>
<p>  &nbsp; &nbsp; &nbsp;(Step Next) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;предыдущую текущей записи</p>
<p>  &nbsp; ---------------------------------------------------------------------</p>
<p>Смотри в главе 6 полное описание всех операций управления записями Btrieve. Глава 5 содержит инструкции по вызову Btrieve</p>
<p>из BASIC, Pascal, COBOL и C. Приложения C, D, E и F содержат примеры программ, иллюстрирующих как инициализировать параметры, выполнять обращения к Btrieve-функциям и проверять возвращаемые статусные коды.</p>
<p>КАК BTRIEVE РАБОТАЕТ</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; NetWare Btrieve - базируемое на сервере дополнение Btrive Record</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Manager, работающее под управлением Advanced NetWare v2.1 и выше.</p>
<p>Все Btrieve-запросы сетевой рабочей станции выполняются на сетевом сервере. По сравнению с программой базируемой у клиента конфигурация базируемая на сервере улучшает операции сетевых баз данных по следующим причинам:</p>
<p>  * Выполнение на сервере является централизованным, допускающим эффективное управление множества пользователей.</p>
<p>  * Количество сетевых запросов уменьшено, что приводит к более быстрому их выполнению из-за улучшенного применения сервера.</p>
<p>  * Уменьшается использование сети из-за меньшего количества данных передаваемых в сети.</p>
<p>Обращения к NetWare Btrieve имеют тот же формат, что и обращения к Btrieve в другой среде. Прикладные задачи единственного пользователя Btrieve, обращающегося к NetWare Btrieve, могут запросить дополнительные проверки статуса благодаря прверке параллелизма, запрашиваемого в многопользовательской среде.</p>
<p>Кроме того, для обеспечения базируемой на сервере системы управления записями для прикладных задач рабочих станций NetWare Btrieve также включает средства, позволяющие VAPs использовать обращения Btrieve к BSERVER. Программа BROUTER обеспечивает необходимую связь между BSERVER и другими VAP-прграммами.</p>
<p>ПРОГРАММА BSERVER</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Программа BSERVER должна быть загружена на каждый файл-сервер,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; где хранятся Btrieve-файлы. BSERVER состоит из ядра программы,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; осуществляющей взаимодействие специальных Btrieve-запросов,</p>
<p>оболочки сервера и модуля сетевых коммуникаций. BSERVER выполняет следующие функции:</p>
<p>  * Она выполняет весь ввод/вывод на диск для Btrieve-файлов хранящихся на сервере, где она резидентно находится.</p>
<p>  * Она запрашивает и отменяет все запреты на уровне записей и на</p>
<p>уровне файлов на сервере, где она резидентно находится.</p>
<p>  * Она об'единяет в пакет все запросы Btrieve, выполняемые ей для передачи копии BREQUEST на рабочую станцию или копии BROUTER на сервер.</p>
<p>Прикладные программы и VAPs, осуществляющие Btrieve-вызовы, всегда взаимодействуют с BSERVER через BREQUEST или через BROUTER.</p>
<p>ПРОГРАМММА BREQUEST</p>
<p>Программа BREQUEST должна быть загружена на каждую станцию, посылающую запросы на сервер. Прикладные программы на рабочих станциях связаны с BSERVER через BREQUEST. BREQUEST выполняет следующие функции:</p>
<p>  * Получает Btrieve-запросы из Вашей прикладной программы и передает их BSERVER.</p>
<p>  * Возвращает результаты Btrieve-запросов в Вашу прикладную задачу.</p>
<p>На рабочих станциях OS/2 BREQUEST.DLL и BTRCALLS.DLL программы динамических связей должны быть доступны прикладной программе. BTRCALLS.DLL-программа должна быть доступна для того, чтобы поддерживать совместимость между NetWare Btrieve и Btrieve для OS/2. BREQUEST.DLL-программа обеспечивает связь между Вашей прикладной программой и BSERVER.</p>
<p>ПРОГРАММА BROUTER</p>
<p>BROUTER-программа загружается на файл-сервер сети. Это - программа межпроцессорной связи, позволяющая VAP-программам загружаемым на файл-серверы сети взаимодействовать с BSERVER. Эта возможность позволяет Вам писать Btrieve прикладную программу как VAP, делая ее расположенной на сервере, а не программой клиента.</p>
<p>BROUTER-программа выполняет следующие функции:</p>
<p>  * Она связывает работу VAP, выполняя Btrieve-прерывание.</p>
<p>  * Она связывает работу всех станций, инициирующих Btrieve- запросы к VAP.</p>
<p>  * Она выполняет доступ к Btrieve-файлам, хранящимся на одном или множестве серверов сети.</p>
<p>  * Она преобразовывает в последовательность Btrieve-запросы</p>
<p>загруженные на одном или более серверов.</p>
<p>Смотрите "Интерфейс с BROUTER" для инструкций по созданию интерфейса с BROUTER.</p>
<p>УПРАВЛЯЮЩАЯ ЛОГИКА</p>
<p>NetWare Btrieve программы функционируют так, как будто они являются подпрограммами Вашей прикладной прграммы. NetWare Btrieve поддерживает два метода доступа к BSERVER:</p>
<p>  * Прикладная задача рабочей станции может иметь доступ к BSERVER через BREQUEST-программу.</p>
<p>  * Прикладная задача рабочей станции может вызывать VAP, который затем взаимодействует с BSERVER через BROUTER.</p>
<p>Следующие разделы описывают эти два метода доступа.</p>
<p>Д о с т у п к BSERVER ч е р е з BREQUEST</p>
<p>Следующие шаги описывают управляющую логику, когда прикладная задача рабочей станции имеет доступ к BSERVER через BREQUEST- программу, загружаемую на рабочую станцию.</p>
<p>  * Ваша прикладная прграмма выдает Btrieve-запрос в форме вызова функции. Действительный вызов реализован несколько по разному в разных языках. Для простоты в данном руководстве будем ссылаться на Btrieve-вызов как на вызов функции.</p>
<p>  * Короткая программа связи, включаемая в Вашу прикладную программу, объединяет параметры вызова в блоки памяти, сохраняет исходный стек и делает обращение к BREQUEST.</p>
<p>  * BREQUEST упаковывает запрос в сетевое сообщение, определяет какой сервер должен получить запрос и пересылает сообщение в BSERVER-программу резидентную на этом сервере.</p>
<p>  * BSERVER получает сетевое сообщение, проверяет достоверность параметров и затем выполняет инструкцию. В зависимости от инструкции могут включаться операция памяти или операция ввода/вывода на системное устройство хранения данных. BSERVER затем возвращает результаты операции в BREQUEST-программу на рабочей станции.</p>
<p>  * BREQUEST возвращает соответствующие данные и код статуса в параметрические переменные или структуры в памяти Вашей прикладной задачи, восстанавливает исходный стек и возвращает управление Вашей программе.</p>
<p>Если прикладная задача на рабочей станции делает Btrieve-запросы как к локальному (неразделенному) устройству, так и к сетевому (разделенному) устройству, то на рабочей станции должна быть загружена копия Btrive Single User (однопользовательский Btrieve) или DOS 3.1 Networks также как и BREQUEST. BREQUEST определяет должен ли запрос быть передан в локальный Btrieve, обслуживающий неразделенные файлы, или в программу BSERVER, обслуживающую разделенные файлы на сервере.</p>
<p>Рисунок 1.2 изображает пример конфигурации для простой сети Novell, использующей NetWare Btrieve.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ФАЙЛ-СЕРВЕР</p>
<p>  &nbsp; &nbsp;-----------&#172; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; -----------------&#172; &nbsp; &nbsp; &nbsp; &nbsp;----------------&#172;</p>
<p>  &nbsp; &nbsp;&#166;Диск сети &#166;&lt;---------&gt;&#166; &nbsp;NetWare &nbsp; &nbsp; &nbsp; &#166;&lt;---&#172; &nbsp; &#166;Локальный диск &#166;</p>
<p>  &nbsp; &nbsp;L----------- &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; +----------------+ &nbsp; &nbsp;&#166; &nbsp; L----------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp;BSERVER.VAP &nbsp; &#166;&lt;---- &nbsp; &nbsp; &nbsp;/ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; L----------------- &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;/ \ &nbsp; / \ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; \ /</p>
<p>  &nbsp; &nbsp;----------------&#172; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;----------------&#172;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;DOS 3.x &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp;DOS 3.x &nbsp; &nbsp; &nbsp;&#166;&lt;--&#172;</p>
<p>  &nbsp; &nbsp;+---------------+ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;+---------------+ &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; NetWare Shell &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;&#166; NetWare Shell &#166; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;+---------------+ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;+---------------+ &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;&lt;------------ &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp;Btrieve &nbsp; &nbsp; &nbsp;&#166;&lt;---</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;BREQUEST &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp;&#166; Record Manager&#166;&lt;--&#172;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;&lt;---&#172; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;+---------------+ &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;+---------------+ &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; L-------&gt;&#166; &nbsp;BREQUEST &nbsp; &nbsp; &#166; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; Прикладная &nbsp; &nbsp;&#166;&lt;---- &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ----&gt;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;&lt;---</p>
<p>  &nbsp; &nbsp;&#166; задача Btrieve&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;+---------------+</p>
<p>  &nbsp; &nbsp;L---------------- &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;&#166; Прикладная &nbsp; &nbsp;&#166;</p>
<p>  &nbsp; &nbsp;Рабочая станция 1 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;L---&gt;&#166; задача Btrieve&#166;</p>
<p>  &nbsp; &nbsp;имеющая доступ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;L----------------</p>
<p>  &nbsp; &nbsp;только к разделенным &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Рабочая станция 2</p>
<p>  &nbsp; &nbsp;Btrieve-файлам &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;имеющая досту</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;к разделенным и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;локальным</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Btrieve-файлам</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Рисунок 1.2</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Конфигурация сети, использующей BSERVER.VAP</p>
<p>  &nbsp; &nbsp;(Обратите внимание, что Рабочая станция 2 имеет доступ как к</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; разделенным так и к локальным файлам )</p>
<p>Рисунок 1.3 иллюстрирует сеть с конфигурацией множества серверов. На этой диаграмме файл-серверы A и B обслуживают разделенные файлы сети. Обратите внимание, все станции сети могут делать запросы к обоим файл-серверам. Программы BREQUEST, загруженные на рабочие станции, посылают запросы на соответствующий файл-сервер. Правильная идентификация файл-серверов и томов существенна для правильного функционирования системы.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ФАЙЛ-СЕРВЕР А</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; -----------------&#172; &nbsp; &nbsp; &nbsp; &nbsp;-----------------&#172;</p>
<p>  &nbsp; &nbsp;------------------------&gt;&#166; &nbsp; &nbsp;NetWare &nbsp; &nbsp; &#166;&lt;------&gt;&#166;Разделенный диск&#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;----------------&#172; &nbsp; &nbsp; +----------------+ &nbsp; &nbsp; &nbsp; &nbsp;L-----------------</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;&#166; &nbsp; &nbsp;DOS 3.x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166; &nbsp;BSERVER.VAP &nbsp; &#166;&lt;-----------------------&#172;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;+---------------+ &nbsp; &nbsp; L----------------- &nbsp;----------------&#172; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;&#166; NetWare Shell &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp;DOS 3.x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;+---------------+ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; +---------------+ &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; NetWare Shell &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;+-&gt;&#166; &nbsp; BREQUEST &nbsp; &nbsp;&#166;&lt;---&#172; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+---------------+ &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;+---------------+ &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ----&gt;&#166; &nbsp; BREQUEST &nbsp; &nbsp;&#166;&lt;----+</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;&#166; Прикладная &nbsp; &nbsp;&#166;&lt;---- &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;&#166; задача Btrieve&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;+---------------+ &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;L---------------- &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;L---&gt;&#166; Прикладная &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;Рабочая станция 1 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; задача Btrieve&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;L---------------- &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Рабочая станция 2 &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;----------------&#172; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;&#166; &nbsp;DOS 3.x &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; ----------&#172; &nbsp; &nbsp; &nbsp; ----------------&#172; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;+---------------+ &nbsp; &nbsp; &nbsp; &#166;Локальный&#166;&lt;-----&gt;&#166; &nbsp; &nbsp;DOS 3.x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;&#166; NetWare Shell &#166; &nbsp; &nbsp; &nbsp; &#166; &nbsp;диск &nbsp; &#166; &nbsp;----&gt;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;+---------------+ &nbsp; &nbsp; &nbsp; L---------- &nbsp;&#166; &nbsp; &nbsp;&#166;---------------&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;&#166; NetWare Shell &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;+-&gt;&#166; &nbsp; BREQUEST &nbsp; &nbsp;&#166;&lt;---&#172; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp;&#166;---------------&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; L---&gt;&#166; Btrieve Record&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;+---------------+ &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ----&gt;&#166; &nbsp; &nbsp;Manager &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;&#166; Прикладная &nbsp; &nbsp;&#166;&lt;---- &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp;+---------------+ &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;&#166; задача Btrieve&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;L---&gt;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;L---------------- &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; BREQUEST &nbsp; &nbsp;&#166;&lt;----+</p>
<p>  &nbsp; &nbsp;&#166; &nbsp;Рабочая станция 3 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;----&gt;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp;+---------------+ &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp;&#166; Прикладная &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; L---&gt;&#166; задача Btrieve&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;L---------------- &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Рабочая станция 4 &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; -----------------&#172; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp;L----------------------&gt;&#166; &nbsp;BSERVER.VAP &nbsp; &#166;&lt;-------------------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+----------------+</p>
<p>  &nbsp; &nbsp;-----------------&#172; &nbsp; &nbsp; &nbsp;&#166; &nbsp; NetWare &nbsp; &nbsp; &nbsp;&#166;</p>
<p>  &nbsp; &nbsp;&#166;Разделенный диск&#166;&lt;----&gt;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;</p>
<p>  &nbsp; &nbsp;L----------------- &nbsp; &nbsp; &nbsp;L-----------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ФАЙЛ-СЕРВЕР B</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Рисунок 1.3</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Сеть с множеством файл-серверов</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(Обратите внимание, что BREQUEST, загруженный на каждую рабочую</p>
<p>станцию, может иметь доступ ко всем файл-серверам. Рабочая станция 4 имеет доступ как к разделенным так и к локальным Btrieve-файлам.)</p>
<p>Если Вы используете множество файл-серверов или интерсеть, все файл-серверы не должны быть в "online" при старте BREQUEST на рабочих станциях. BREQUEST распознает новые файл-серверы или устройства при обращении к новому файл-серверу или при изменении распределения сетевых устройств.</p>
<p>Д о с т у п к BSERVER ч е р е з BROUTER</p>
<p>------------------------------------</p>
<p class="note">Примечание:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Если Вы не используете Value-Added Process (VAP), доступный</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;NetWare Btrieve, можете пропустить этот раздел.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;______________________________________________________________</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующие шаги иллюстрируют управляющую логику при обращении</p>
<p>прикладной программы рабочей станции к VAP, который затем обращается к BSERVER через программу BROUTER.</p>
<p>  * Прикладная программа рабочей станции посылает запрос к VAP. Запрос может быть сформирован как Btrieve-вызова или в форме, треуемой VAP.</p>
<p>  * Программа связи, включенная в прикладную программу. упаковывает запрос в сообщение сети, определяет какой сервер должен получить запрос и посылает соощение в VAP, резидентный на сервере.</p>
<p>  * VAP получает сообщение сети, проверяет правильность параметров и упаковывает параметры вызова как Btrieve-запрос в блок памяти. Затем сохраняет ID клиента в регистре AX и выполняет прерывание 7B.</p>
<p>  * BROUTER получает Btrieve-запрос, сохраняет информацию об источнике вызова и вызывает копию BSERVER, активную на сервере, где хранится файл.</p>
<p>  * BSERVER выполняет запрос и возвращает результаты операции в BROUTER.</p>
<p>  * BROUTER возвращает соответствующие данные и код статуса в параметрические переменные или структуры в памяти VAP и возвращает управление VAP.</p>
<p>  * VAP возвращает соответствующую информацию в прикладную программу на рабочей станции.</p>
<p>Если прикладная программа рабочей станции делает Btrieve-запрос к локальному (неразделенному) устройству и к VAP, вызывающему</p>
<p>Btrieve, копия Btrieve Single User или DOS 3.1 Networks должна быть загружена на рабочую станцию. Рисунок 1.4 иллюстрирует логику управления, когда VAP имеет доступ к Btrieve-файлам используя NetWare Btrieve.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;РАБОЧАЯ СТАНЦИЯ</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;--------------&#172;</p>
<p>  &nbsp; &nbsp; &nbsp;1. Прикладная программа &nbsp; &nbsp; &#166; &nbsp;Прикладная &#166;</p>
<p>  &nbsp; &nbsp; &nbsp;на рабочей станции &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp;программа &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp;посылает запрос в VAP1 &nbsp; &nbsp; &nbsp;+-------------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;Интерфейс VAP&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;L---T----------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; / &nbsp; &nbsp; &nbsp; &nbsp;2. Интерфейс VAP1 посылает &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; 7. VAP1 возвращает</p>
<p>  &nbsp; &nbsp; &nbsp;запрос на сервер &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; результаты</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; прикладную программу</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; рабочей станции</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;СЕРВЕР&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; \ / &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;---------+--&#172;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ---+ &nbsp; VAP1 &nbsp; &nbsp;&#166;&lt;-&#172;</p>
<p>  &nbsp; &nbsp; &nbsp;3. VAP1 упаковывает запрос &#166; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp;&#166; &nbsp;6. BROUTER возвращает</p>
<p>  &nbsp; &nbsp; &nbsp;и выполняет прерывание &nbsp; &nbsp; &#166; &nbsp;+-----------+ &nbsp;&#166; &nbsp;результаты в VAP1</p>
<p>  &nbsp; &nbsp; &nbsp;7B &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; L-&gt;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; +---</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp;BROUTER &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp;4. BROUTER получает Btrieve---+ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;&lt;-&#172; &nbsp;5. BSERVER выполняет</p>
<p>  &nbsp; &nbsp; &nbsp;вызов и посылает его в &nbsp; &nbsp; &#166; &nbsp;+-----------+ &nbsp;&#166; &nbsp;запрос и посылает</p>
<p>  &nbsp; &nbsp; &nbsp;BSERVER &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp;&#166; &nbsp;результаты в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; L-&gt;&#166; &nbsp;BSERVER &nbsp;+--- &nbsp;BROUTER</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; -------&#172;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;&lt;---&gt;&#166; Диск &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;L------------ &nbsp; &nbsp; L-------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Рисунок 1.4</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Применение другого VAP с BSERVER</p>
<p>КЭШ-БУФЕРЫ</p>
<p>Кэш-память - область памяти, резервируемая BSERVER для буферизации страниц, читаемых с диска. Вы определяете размер кэш-памяти при конфигурации BSERVER. Кэш-память разделена на ряд буферов, каждый - имеющий размер самой большой страницы, к которой будет иметь доступ Ваша прикладная программа. В основном большая кэш-память улучшает выполнение, т.к. позволяет большему количеству страниц быть в памяти в данное время. (См. Главу 3 для дополнительной информации о конфигурации BSERVER.)</p>
<p>Когда Ваша прикладная программа делает запрос какой-либо записи, BSERVER сперва проверяет кэш-память ,чтобы посмотреть не находится ли уже страница, содержащая эту запись, в памяти. Если запись уже в кэш-памяти, BSERVER пересылает запись из кэш-памяти в буфер данных Вашей прикладной программы. Если страницы нет в кэш-памяти, BSERVER копирует страницу с диска в кэш-буфер до того, как пересылает требуемую запись в Вашу прикладную программу.</p>
<p>Если все кэш-буферы заполнены, когда BSERVER необходимо передать новую страницу в память, по алгоритму "наименьшего использования" (LRV) определяется, какую страницу BSERVER перекрывает в кэш-памяти. LRU уменьшает время выполнения, сохраняя наиболее употребляемые страницы в памяти.</p>
<p>Когда Ваша прикладная программа добавляет или корректирует запись, BSERVER сперва модифицирует страницу в кэш-памяти, а затем записывает страницу на диск, Модифицированная страница остается в кэш-памяти до тех пор, пока LRU не определит, что она должна быть перекрыта новой страницей.</p>
<p>ПАРАМЕТРЫ ОБРАЩЕНИЯ К BTRIEVE</p>
<p>Btrieve запрашивает определенную информацию из Вашей прикладной программы для выполнения операций управления записями и файлами. Ваша прикладная программа использует параметры Btrieve-обращения для задания информации, необходимой Btrieve и обеспечения места для возвращаемой Btrieve информации. При каждом обращении к Btrieve Ваша прикладная программа должна передать Btrieve все параметры, требуемые используемым Вами языком, даже если Вы и не ждете их значений. Этот раздел дает общее описание параметров и как Btrieve их использует.</p>
<p>------------------------------------</p>
<p class="note">Примечание:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Для специфической информации о том, как использовать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; параметры в определенном языке см. Главу 5 "Интерфейс</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; языков". Для информации о том, как Btrieve использует</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; параметр для конкретной операции см. Главу 6 "Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; операции записи".</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;-----------------------------------------------------------</p>
<p>КОД ОПЕРАЦИИ</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Параметр кода операции сообщает Btrieve, какую операцию Вы хотите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; выполнить. Ваша прикладная программа должна задавать код операции</p>
<p>при каждом обращении к Btrieve. Переменная, которую Вы определяете для хранения кода операции, должна быть 2-байтовым целым числом. Btrieve никогда не изменяет значение кода операции.</p>
<p>КОД СТАТУСА</p>
<p>Все Btrieve-операции возвращают значение кода статуса, информируя Вашу прикладную программу обо всех ошибках. Код статуса равный 0 показывает, что операция выполнена успешно. Для некоторых языков, в частности для С и Паскаля, вызов Btrieve - целая функция и Вашей прикладной программе не требуется задавать отдельный параметр для кода операции. Если Вы применяете язык, требующий отдельного параметра кода операции, задайте 2-байтовое целое для хранения возвращаемого значения.</p>
<p>БЛОК ПОЗИЦИИ</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve использует параметр блока позиции для хранения указателей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; позиционирования и другой информации, необходимой для доступа к</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; какому-либо файлу. Ваша прикладная программа использует блок</p>
<p>позиции для определения Btrieve-файла, к которому Вы хотите получить доступ при выполнении некоторой операции. Btrieve ожидает, что блок позиции - это 128-байтовый блок памяти. В зависимости от прикладного языка блок позиции может быть строкой, массивом или частью буфера файла (как, например, в Бейсике).</p>
<p>Ваша прикладная программа должна присвоить уникальный блок позиции каждому Btrieve-файлу, его необходимо открыть и проинициализировать блоком пробелов или двоичных нулей до выполнения операции Open. Ваша прикладная программа НИКОГДА не должна писать в блок позиции после того, как он был проинициализирован и присвоен файлу, до тех пор пока Вы не</p>
<p>выполните над файлом операцию Close. Вы можете тогда переинициализировать блок позиции таким образом, чтобы его можно было использовать для другого Btrieve-файла. Запись в блок позиции для открытого Btrieve--файла может привести к ошибкам или повреждению файла,</p>
<p>БУФЕР ДАННЫХ</p>
<p>Буфер данных - блок памяти, содержащий специфический вид информации, требуемый Btrieve-операцией.</p>
<p>Для операций, в которые вовлечена запись или чтение Btrieve- файла, блок данных содержит записи, которые Ваша прикладная программа передает в файл и из файла. Например, когда Ваша прикладная программа ищет запись в файле, Btrieve читает запись из файла и затем записывает запись в область памяти, указанную как блок записи для этой операции.</p>
<p>Для других операций блок данных содержит спецификации файла, определения и другую информацию, необходимую Btrieve для выполнения операции. Когда Ваша прикладная программа выполняет операцию Create, например, она создает блок данных, содержащий спецификации для создаваемого Вами файла в порядке, ожидаемом Btrieve. Btrieve затем читает буфер данных и создает файл согласно спецификации.</p>
<p>Btrieve распознает буфер данных как ряд байтов в памяти. Он не различает какие-либо поля или переменные как объекты буфера данных. Вы можете определить буфер данных как любой тип переменных, поддерживаемых Вашим языком: структурой, массивом или простой строковой переменной. Для некоторых версий Бейсика буфер данных - область Блока управления файла (FCB), определяемая сегментом FIELD.</p>
<p>ДЛИНА БУФЕРА ДАННЫХ</p>
<p>Для всех операций, требующих буфер данных, Ваша прикладная программа должна задать для Btrieve длину буфера данных в байтах. Это необходимо потому, что</p>
<p>  * Btrieve позволяет Вам определять файлы, допускающие записи переменной длины. Вы должны задать, какое количество байтов Вам хочется прочитать из этих записей или записать в них.</p>
<p>  &nbsp; * Btrieve не распознает какие-либо структуры данных Вашей программы. Он явно не знает длину буфера данных в байтах. Это создает возможность записи данных, не имеющих значений, в Ваши файлы или возврата большего количества данных, чем может содержать буфер данных, и наложения записей на область памяти, следующую за буфером данных.</p>
<p>Ваша прикладная программа должна определить буфер данных как 2-байтовое целое, При всех операциях Btrieve записывает некоторое значение в параметр длины буфера данных, даже если это значение равно 0 (показывающее, что не было возвращено данных). Поэтому Вы должны всегда инициализировать буфер данных соответствующей длины</p>
<p>для какой-либо операции до вызова Btrieve.</p>
<p>Применяйте следующие правила для инициализации значения параметра длины буфера данных:</p>
<p>  * Когда Вы читаете из существующего файла или пишете в существующий файл и файл содержит записи фиксированной длины, задавайте значение равное длине записи, определенное для этого файла.</p>
<p>  * Когда Вы читаете из существующего файла или пишете в существующий файл и файл содержит записи переменной длины, задавайте значение равное длине, определенной для фиксировнной части записи, плюс количество байтов, которое Вы хотите читать или писать за фиксированной частью.</p>
<p>  * Когда Вы запрашиваете какую-либо другую операцию, задавайте точную длину буфера данных, требуещуюся для этой операции. Эти требования включены в обсуждение Btrueve-операций в Главе 5 этого руководства.</p>
<p>БУФЕР КЛЮЧА</p>
<p>Ваша прикладная программа должна посылать переменную для буфера ключа при каждом обращении к Btrieve. В зависимости от операции Ваша прикладная программа может устанавливать буфер ключа в определенное значение или Btrieve может возвращать значение буфера ключа.</p>
<p>Для некоторых языков Btrieve не может явно определить длину буфера ключа. Поэтому Вы должны всегда удостовериться, что заданная Вами переменная для буфера ключа имеет достаточную длину для хранения всего значения, требуемого для операции. Иначе Btrieve-запросы могут повредить другие данные, хранимые в следующей за буфером ключа памяти.</p>
<p>НОМЕР КЛЮЧА</p>
<p>Параметр номера ключа всегда 2-байтовая целая переменная со знаком. Для большинства Btrieve-операций этот параметр сооббщает Record Manager о пути доступа в этой операции. Для других операций Ваша прикладная программа использует параметр номера ключа для задания режима открытия файла, шифровки, логического устройства или другой информации. Btrieve никогда не изменяет значение параметра номера ключа.</p>
<p>Когда Вы используете параметр номера ключа для задания пути доступа к файлу, номер должен быть от 0 до 23, т.к. Btrieve допускает до 24 ключей или ключевых сегментов в файле.</p>
<p>ИНТЕРФЕЙС ЯЗЫКА</p>
<p>Интерфейс языка обеспечивает связь между Вашей прикладной программой и Btrieve. Интерфейс языка специфичен для определенного языка, компилятора и среды.</p>
<p>Когда Ваша прикладная программа обращается к Btrieve, интерфейс делает предварительные проверки параметров и проверяет, находится ли Btrieve Record Manager резидентно в памяти. Если интерфейс не обнаруживает ошибок, он выполняет соответствующее обращение для операционной среды, активизируя программу Record Manager.</p>
<p>ГЛАВА 3. ЗАПУСК СЕТИ BTRIEVE</p>
<p>Эта глава содержит информацию, необходимую для инсталяции и конфигурации NetWare Btrieve для Вашей системы.</p>
<p>СИСТЕМНЫЕ ТРЕБОВАНИЯ</p>
<p>NetWare Btrieve должeн запускаться под управлением NetWare v2.1x или выше. Для обеспечения индивидуальных операций записи на диск и сохранности файлов и их восстановления в случае сбоя файл-сервера требуется Система связи транзакций (Transaction Tracking System).</p>
<p>------------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;В а ж н о :</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Сеть Btrieve не запускается под управлением</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ELS NetWare уровня I или Advanced NetWare 68, т.к.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;эти версии не поддерживают Value-Added Processes</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;----------------------------------------------------</p>
<p>Btrieve требует сетевой файл-сервер с памятью, достаточной для загрузки сети, BSERVER и BROUTER. В большинстве случаев файл-сервер должен иметь минимум 2МВ памяти для эффективного запуска и NetWare, и Btrieve.</p>
<p>Программа "Btrieve инициатор запросов" (BREQUEST) требует приблизительно 25КВ памяти для каждого рабочего места (при допущении, что она загружена со стандартными режимами запуска). Точное количество требуемой памяти зависит от заданных Вами режимов запуска при загрузке программы.</p>
<p>Если Вы используете систему межсетевого обмена, рабочие станции на вершинах этих сетей, использующие NetWare Btrieve, должны иметь доступ к файл-серверу, загруженному с BSERVER и BROUTER.</p>
<p>B T R I E V E - Д И С К Е Т Ы</p>
<p>NetWare Btrieve расположен на двух дискетах: дискете с программами "PROGRAMS" и дискете с утилитами "UTILITES". Вы должны сделать копии Btrieve-дискет, сохранив дискеты-оригиналы на случай повреждения или потери копий. Дискеты-оригиналы Btrieve имеют защиту записи, поэтому Вы не можете случайно уничтожить или</p>
<p>заменить их содержание.</p>
<p>Дискета "PROGRAMS" содержит следующие файлы:</p>
<p>ФАЙЛ ОПИСАНИЕ</p>
<p>BSERVER.VAP Файл, загружаемый NetWare как Value-Added Process</p>
<p>на файл-сервер</p>
<p>BROUTER.VAP Программа сообщений Btrieve. Эта программа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; используется для обеспечения межпроцессорных</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; связей между BSERVER и другими VAP-продуктами,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;такими как NetWare SQL.</p>
<p>BREQUEST.EXE Btrieve инициатор запросов для рабочих станции</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;DOS. Это резидентная в памяти программа,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;загружаемая Вами на каждую рабочую станцию,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; делающую Btrieve-запросы. BREQUEST пересылает</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Btrieve-запросы из Вашей &nbsp;прикладной программы на</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;файл-сервер.</p>
<p>BREQURST.DLL Btrieve инициатор запросов для рабочих станций</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;OS/2. Это библиотека динамических связей, которую</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;OS/2 связывает с каждой прикладной прграммой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Btrieve. Программы BREQUEST пересылают</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Btrieve-запросы из Вашей прикладной программы в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;файл-сервер.</p>
<p>BTRCALLS.DLL Btrieve-подпрограмма динамических связей для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; рабочих станций OS/2. Эта программа включена</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; для устранения необходимости повторного</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; редактирования связей программ OS/2 специально</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;для NetWare Btrieve.</p>
<p>Дискета "UTILITIES" содержит следующие файлы:</p>
<p>BUTIL.EXE Автономная утилита Btrieve.</p>
<p>BSETUP.EXE Утилита конфигурации и инсталяции Btrieve.</p>
<p>BSETUP.HLP Файл сообщений для программы BSETUP.</p>
<p>BASXBTRV.EXE Резидентный в памяти BASIC-интерфейс,</p>
<p>используемый BASIC-интерпритатором.</p>
<p>BASXBTRV.OBJ Объектный модуль, содержащий интерфейс IBM</p>
<p>Compiled BASIC с Btrieve</p>
<p>QBIXBTRV.OBJ Объектный модуль, содержащий интерфейс</p>
<p>Microsoft QuickBASIC с Btrieve.</p>
<p>PASXBTRV.OBJ Объектный модуль, содержащий интерфейс</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Паскаля для IBM (или Microsoft) компилятора</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Паскаля</p>
<p>TURXBTRV50S Исходный модуль, содержащий интерфейс</p>
<p>Паскаля для компилятора Турбо-Паскаля.</p>
<p>BEXTERN51S Исходный файл Паскаля, содержащий внешнее</p>
<p>объявление для функции BTRV.</p>
<p>COBXBTRV.OBJ Объектный модуль, содержащий интерфейс</p>
<p>Кобола для компилятора Microsoft Cobol, v2.</p>
<p>MSCXBTRV.C Исходный модуль для интерфейса Microsoft C</p>
<p>с Btrieve.</p>
<p>C2XBTRV.C Исходный модуль интерфейса C, используемый</p>
<p>в прикладных задачах OS/2 в защищенном режиме.</p>
<p>C2FXBTRV.C Исходный модуль интерфейса C, используемый в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; прикладных задачах OS/2 FAPI, запускаемых или в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;защищенном режиме или в режиме эмуляции.</p>
<p>UPPER.ALT Файл, содержащий определение альтернативной</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; последовательности поиска, которая сравнивает</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;клавиши верхнего и нижнего регистра, как будто бы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;они были все на верхнем регистре.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp;B.EXE &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Исполнитель Btrieve-функций, тестирующая и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; обучающая программа.</p>
<p>README.DOC Документ, описывающий любые изменения или</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; дополнения в Btrieve со времени опубликования</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;руководства.</p>
<p>INTRFACE.DOC Документ, описывающий интерфейс с языками,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; поставленный на дискете Btrieve, но не</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; обсуждаемый в данном руководстве.</p>
<p>К О Н Ф И Г У Р А Ц И Я И И Н С Т А Л Я Ц И Я BTRIEVE</p>
<p>До того, как Ваша прикладная программа сможет иметь доступ к NetWare Btrieve, Вы должны сперва конфигурировать Btrieve- программы и затем инсталировать их на файл-сервер.</p>
<p>Файлы BSERVERR.VAP и BROUTER.VAP, включенные на дискету "PROGRAMS", снабжены стандартными вариантами инициализации. Т.к. эти значения адекватны для многих систем, возможно, Вам не потребуется их корректировать. В этой главе обсуждаются варианты конфигурации Btrieve и объясняется, как применять программу BSETUP.EXE для конфигурации и инсталяции соответствующих Вашим требованиям версий BSERVER.VAP и BROUTER.VAP на Вашем файл-сервере.</p>
<p>РЕЖИМЫ КОНФИГУРАЦИИ BTRIEVE</p>
<p>Для правильного функционирования Btrieve при загрузке должен зарезервировать память и ресурсы. Вы можете установить в Btrieve требования для своей системы, задавая набор опций конфигурации. Они</p>
<p>включают:</p>
<p>  * Максимальное число открытых файлов.</p>
<p>  * Максимальное число обрабатываемых файлов.</p>
<p>  * Максимальное число блокировок записей.</p>
<p>  * Число парралельных транзакций.</p>
<p>  * Максимальный размер буфера сжатия.</p>
<p>  * Максимальная длина записи.</p>
<p>  * Максимальный размер страницы.</p>
<p>  * Максимальное число параллельных сеансов.</p>
<p>  * Время задержки обновления консоли.</p>
<p>  * Автоматическая установка флагов транзакций.</p>
<p>В разделах на следующих страницах обсуждается каждая опция, заданные по умолчанию значения и требуемая при необходимости память.</p>
<p>М а к с и м а л ь н о е ч и с л о о т к р ы т ы х ф а й л о в</p>
<p>Границы: 1-255</p>
<p>По умолчанию: 20</p>
<p>Требуемая память для каждого файла: 115 байт</p>
<p>Опция "Максимальное число открытых файлов" позволяет Вам задать максимальное число уникальных файлов, которое можно открыть на файл-сервере в люббое время. Btrieve использует заданное Вами значение для определения размера внутренних таблиц, используемых для доступа к активным файлам. Каждый уникальный Btrieve-файл на файл-сервере треббует один вход.</p>
<p>М а к с и м а л ь н о е ч и с л о о б р а б а т ы в а е м ы х ф а й л о в</p>
<p>Границы: 1-&lt;предел сети&gt;</p>
<p>По умолчанию: 60</p>
<p>Требуемая память для каждого обрабатываемого файла: 114 байт</p>
<p>Опция "Максимальное число обрабатываемых файлов" позволяет Вам задать максимальное число обрабатываемых файлов, которое Btrieve позволяет одновременно использовать Вашей системе. Если две станции открывают один и тот же файл на файл-сервере, они используют два обрабатываемых файла. Для вычисления максимального числа обрабатываемых файлов умножьте число станций на максимальное число файлов, которые можно открыть на каждой рабочей станции.</p>
<p>М а к с и м а л ь н о е ч и с л о б л о к и р о в о к з а п и с е й</p>
<p>Границы: 0 - &lt;предел сети&gt;</p>
<p>По умолчанию: 20</p>
<p>Требуемая память для каждой блокировки: 8 байт</p>
<p>Опция "Максимальное число блокированных записей" устанавливает максимальное число записей, которое может быть заблокировано одновременно на файл-сервере. Она определяет число входов для таблицы запретов, которую Btrieve строит при загрузке. Значение этой опции включает блокировки как единственной так и множества записей. Для вычисления значения этой опции определите максимальное число записей, которое можно открыть на каждой рабочей станции, и умножьте это число на число рабочих станций, имеющих доступ к Btrieve-файлам.</p>
<p>Ч и с л о п а р р а л е л ь н ы х т р а н з а к ц и й</p>
<p>Границы: 0 - &lt;максимальное число сеансов&gt;</p>
<p>По умолчанию: 0</p>
<p>Требуемая память для каждой транзакции: 1 046 байтов</p>
<p>Опция "Число парралельных транзакций" устанавливает максимальное число станций, которые могут иметь парралельные активные транзакции на файл-сервере. Если Вы задаете для этой опции значение равное 0, ни одна из рабочих станций не может запрашивать операцию Begin Transaction на файл-сервере. Если Вы задаете для этой опции значение большее 0, Btrieve создает файл транзакций BTRIEVE.TRN в директории \SYS\SYSTEM на файл-сервере и позволяет Вам использовать столько активных транзакций, сколько Вы задали.</p>
<p>М а к с и м а л ь н ы й р а з м е р с ж а т о й з а п и с и</p>
<p>Границы: 0 - &lt;самая длинная запись в сжатом файле&gt;</p>
<p>По умолчанию: 0</p>
<p>Требуемая память для каждой транзакции: 2 * число заданных килобайт</p>
<p>Опция "Максимальный размер сжатой записи" задает размер (в килобайтах) самой длинной записи в сжатом файле, к которой Вы будете иметь доступ. Btrieve расположит заданное Вами удвоенное число килоайт в свой буфер сжатия. Задание большего, чем Вам необходимо, значения не приведет к улучшению выполнения, а может привести к уменьшению памяти, доступной для других процессов на файл-сервере.</p>
<p>Если Вы используете сжатые файлы, установите значение для этой опции, равные размеру самой длинной записи в Ваших сжатых файлах. Задавайте значение в килобайтах. Округляйте все значения до следующего большего килобайта. Например, если самая длинная запись допускает длину 1 800 байт, задайте значение 2 для этой опции.</p>
<p>Если Вы не используете сжатые файлы, установите значение в 0.</p>
<p>М а к с и м а л ь н а я д л и н а з а п и с и</p>
<p>Границы: 4 байта - 32KB</p>
<p>По умолчанию: 8 912 байт</p>
<p>Требуемая память: (заданное значение + 269 байт)</p>
<p>Опция "Максимальная допустимая длина записи" задает длину самой длинной записи, которую допускает прикладная задача Btrieve на этом файл-сервере. Всегда задавайте длину записи в байтах. Задание большего значения, чем Вам необходимо, не приводит к улучшению выполнения.</p>
<p>М а к с и м а л ь н ы й р а з м е р с т р а н и ц ы</p>
<p>Границы: 512 - 4 096 байт</p>
<p>По умолчанию: 4 096 байт</p>
<p>Требуемая память: нет</p>
<p>Опция "Максимальный допустимый размер страницы" позволяет Btrieve вычислять размер необходимых кэш-буферов. Значение, что Вы здесь задаете, должно равняться максимальному размеру страницы Btrieve-файла, к которому Вы хотите иметь доступ. Оно должно быть кратно 512 байтам, но не больше чем 4 096 байт.</p>
<p>М а к с и м а л ь н о е ч и с л о п а р а л л е л ь н ы х с е а н с о в</p>
<p>Границы: 1-&lt;число задач на рабочей станции&gt;</p>
<p>По умолчанию: 15</p>
<p>Требуемая память для каждого сеанса: 1 296 байт</p>
<p>Опция "Максимальное число параллельных сеансов" задает максимальное число задач на рабочей станции, которые могут иметь доступ к BSERVER в любое время. Сеанс определяется как одна копия связи BREQUEST с программой BSERVER. Каждый сеанс занимает два пакетных буфера Btrieve-запросов.</p>
<p>Задание большего значения, чем Вам необходимо, не приводит к улучшению выполнения.</p>
<p>В р е м я з а д е р ж к и о б н о в л е н и я к о н с о л и</p>
<p>Границы: 1 - 60 секунд</p>
<p>По умолчанию: 3 секунды</p>
<p>Требуемая память: нет</p>
<p>Опция "Время задержки обновления консоли" управляет числом секунд задержки B STATUS и B ACTIVE перед обновлением экрана новой информацией. Задержка позволяет Вам сохранить читабельность информациии, наблюдая эффект работы базы данных в режиме реального времени.</p>
<p>А в т о м а т и ч е с к а я у с т а н о в к а ф л а г о в т р а н з а к ц и й</p>
<p>Границы: Да/Нет</p>
<p>По умолчанию: Нет</p>
<p>Требуемая память: нет</p>
<p>Опция "Автоматическая установка флагов транзакций" управляет автоматической установкой флагов файлов как допускающих транзакции во время создания их Вами в системе. Если Вы ответите "Yes" ("Да"), Btrieve установит флаги транзакций для вновь создаваемых файлов. во время создания их Вами в системе. Если Вы ответите "No" ("Нет"), Btrieve не установит флаги транзакций для файлов.</p>
<p>задать максимальное число уникальных файлов,</p>
<p>ОПЦИИ ИНСТАЛЯЦИИ</p>
<p>Программа BSETUP создана для предоставления Вам следующих опций инсталяции:</p>
<p>  * Вы можете инсталировать BSERVER и BROUTER непосредственно на файл-сервере. В этой ситуациия Вы должны войти в систему как SUPERVISOR или иметь права супервизора. Если Вы не вошли в сисиему как SUPERVISOR, опции "Install" и "Remove" не будут отображены в меню.</p>
<p>  * Вы можете скопировать файлы BSEVER.VAP и BROUTER.VAP в поддиректорию или на дискету, запустить BSETUP для конфигурации копии, и затем инсталировать копию на текущем файл-сервере или переслать файл на другой файл-сервер.</p>
<p>ЗАПУСК BSETUP</p>
<p>Для запуска BSETUP выполните следующие шаги:</p>
<p>  1. Стартуйте персональный компьютер, который Вы будете использовать для запуска BSETUP.</p>
<p>  2. Скопируйте файлы BSEVER.VAP и BROUTER.VAP в поддиректорию или на дискету, в зависимости от опций инсталяции.</p>
<p>  3. Удостоверьтесь, что текущая директория - поддиректория, на которую Вы скопировали программы NetWare Btrieve.</p>
<p>  4. После подсказки DOS введите следующую команду:</p>
<p>BSETUP &lt;&lt;Enter&gt;</p>
<p>ПРИМЕНЕНИЕ BSETUP</p>
<p>Когда BSETUP загружен, появится меню подобное следующему:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Available Options</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Change File Server</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Install Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Remove Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Save Configuration</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Set Configuration</p>
<p>В следующих разделах обсуждается каждая опция и дается информация об их применении для конфигурации и инсталяции Btrieve. Опции представлены в наиболее вероятном порядке выполнения. Если Вам нужна более детальная помощь по задаче выполняемой в настоящее время, нажмите клавишу F1 (Помощь).</p>
<p>Используйте клавиши Up и Down , чтобы высветить опции меню. Если Вы</p>
<p>хотите выйти из меню, нажмите &lt;Esc&gt;.</p>
<p>Для выхода из BSETUP нажмите &lt;Esc&gt; в меню "Available Options" и высветите "Yes" в меню "Exit BSETUP".</p>
<p>CHANGE FILE SERVER</p>
<p>(Изменение файл-сервера)</p>
<p>Опция "Change File Server" позволяет Вам выбрать файл-сервер, на котором Вы хотите конфигурировать, инсталировать, удалить или сохранить NetWare Btrieve.</p>
<p>Для изменения файл-серверов выполните следующие шаги:</p>
<p>  1. Используйте клавиши Up и Down , чтобы высветить опцию "Change File Server" и нажмите &lt;Enter&gt;.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Появится меню, перечисляющее имена файл-серверов подключенных</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; к рабочей станции в текущее время.</p>
<p>2) Используйте клавиши Up и Down , чтобы высветить имя файл-сервера</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; на котором Вы хотите выполнять операцию BSETUP и нажмите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &lt;Enter&gt;.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Будет короткая пауза и вновь появится меню "Available</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Options"</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если у Вас есть права супервизора на выбранном Вами</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файл-сервере, появятся все опции меню. Вы сможете сейчас</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; конфигурировать, инсталировать, удалять или сохранять NetWare</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve на этом файл-сервере.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если у Вас нет прав супервизора на выбранном Вами</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файл-сервере, опции "Install NetWare Btrieve" и "Remove</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; NetWare Btrieve" не появятся. Вы сможете только</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; конфигурировать и сохранять конфигурацию NetWare Btrieve на</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файл-сервере, на котором Вы не имеете прав супервизора.</p>
<p>SET CONFIGURATION</p>
<p>(Установка конфигурации)</p>
<p>Опция "Set Configuration" позволяет Вам определять опции Btrieve для копирования Btrieve в текущую директорию.</p>
<p>------------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;В а ж н о :</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Если BSERVER.VAP и BROUTER.VAP нет в текущей директории,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; когда Вы пытаетесь установить опции инициализации,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; BSETUP возвратит сообщение об ошибке и прервет выполнение.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;----------------------------------------------------------</p>
<p>Чтобы установить одну или несколько опций инициализации, выполните следующие шаги:</p>
<p>  1. Высветите меню "Set Configuration" в меню "Available Options" и нажмите &lt;Enter&gt;.</p>
<p>Появится меню подобное следующему:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Number of open files: 20</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Number of handles: 60</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Number of locks: 20</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Number of transactions: 0</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Largest compressed record size: 8192</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Largest page size: 4096</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Number of sessions: 15</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Console refresh count: 3</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Create files as transactional: Yes</p>
<p>Значения, отображенные в поле правой колонки, - это значения, определенные для этой опции в последний раз. Если Вы конфигурируете новую копию NetWare Btrieve, в полях появятся значения, заданные по умолчанию.</p>
<p>2) Высветите поле, которое Вы хотите задать.</p>
<p>3) Введите новое значение и нажмите &lt;Enter&gt;.</p>
<p>Если Вы нажмете &lt;Esc&gt;, будет действовать предыдущее определение опции.</p>
<p>Если Вы введете неверное для этой опции значение, BSETUP предупредит Вас об ошибке. В этот момент Вы можете удалить неправильное значение и ввести верное значение.</p>
<p>4) Продолжайте высвечивать поля и вводить новые значения для всех</p>
<p>опций, что Вы хотите определить.</p>
<p>Когда Вы введете нужные значения, нажмите &lt;Esc&gt;, чтобы вернуться в меню " Available Options". Вы должны выполнить опцию "Save Configuration" для того , чтобы заданные вновь значения были сохранены в программах NetWare Btrieve в текущей директории.</p>
<p>SAVE CONFIGURATION</p>
<p>(Сохранение конфигурации)</p>
<p>Опция "Save Configuration" позволяет Вам сохранять конфигурацию Btrieve в копиях BSERVER.VAP и BROUTER.VAP в текущей директории. Вы не обязаны входить в систему как SUPERVISOR для сохранения новой конфигурации Btrieve.</p>
<p>Чтобы сохранить новую конфигурацию Btrieve, выполните следующие</p>
<p>шаги:</p>
<p>  1. Высветите "Save Configuration" и нажмите &lt;Enter&gt;.</p>
<p>Появится подсказка "Update Btrieve".</p>
<p>2) Высветите "Yes" и нажмите &lt;Enter&gt;.</p>
<p>Когда Вы сохраните новую конфигурацию, BSETUP установит новые значения опций Btrieve в копиях BSERVER.VAP и BROUTER.VAP, хранящихся в текущей директории.</p>
<p>BSETUP вернет Вас в меню "Available Options".</p>
<p>Если Вы хотите, чтобы новая конфигурация действовала на текущем файл-сервере, выполните опцию "Install Btrieve' в меню "Available Options" и затем перезагрузите сеть.</p>
<p>INSTALL BTRIEVE</p>
<p>(Инсталяция Btrieve)</p>
<p>Опция " Install Btrieve" позволяет Вам инсталировать Btrieve на файл-сервере, в который Вы вошли в данный момент. Вы должны войти в систему как SUPERVISOR или иметь права супервизора для инсталяции Btrieve на файл-сервере.</p>
<p>Для инсталяции Btrieve, выполните следующие шаги:</p>
<p>  1. Высветите опцию "Install Btrieve" в меню "Available Options" и нажмите &lt;Enter&gt;.</p>
<p>Если NetWare Bteieve не инсталирован на текущем файл-сервере, появтися бокс входа, подсказывающий ввести пароль для Btrieve.</p>
<p>Если NetWare Bteieve уже инсталирован на текущем файл-сервере, появтися подсказка, спрашивающая хотите ли Вы заменить инсталированные в данное время программы. Если - да, то выполните следующие шаги:</p>
<p>  1. Для отмены инсталяции и возврата в меню "Available Options", высветите "No" и нажмите &lt;Enter&gt;, или нажмите &lt;Esc&gt;.</p>
<p>  2. Для замены существующей конфигурации высветите "Yes" и нажмите &lt;Enter&gt;.</p>
<p>Если Вы ответите "Yes" на подсказку "Replace Bteieve", появтися бокс входа, подсказывающий ввести пароль для Btrieve.</p>
<p>3) NetWare Btrieve требует пароль для идентификации себя в NetWare</p>
<p>Это предохраняет от получения доступа к NetWare неавторизированных программ через объектное имя Btrieve.</p>
<p>Для отмены инсталяции в этот момент и возврата в меню "Available Options" нажмите &lt;Esc&gt;.</p>
<p>Для продолжения инсталяции введите пароль для Btrieve из не болле, чем восьми символов, и нажмите &lt;Enter&gt;. Если Вы не хотите задавать пароль, но хотите продолжить инсталяцию, нажмите &lt;Enter&gt; при подсказке пароля. Появится подсказка "Install BROUTER".</p>
<p>------------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;В а ж н о :</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Подсказка пароля - это последний шаг процесса инсталяции,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; когда Вы можете полностью отменить инсталяцию без инсталяции</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; программ NetWare Btrieve. Если Вы продвинулись немного дальше</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; в этом процессе, Вы должны синсталировать по крайней мере</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; программу BSERVER.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;----------------------------------------------------------</p>
<p>4) Подсказка "Install BROUTER" дает Вам опцию инсталяции программы BROUTER в то же самое время, что и BSERVER.</p>
<p>Для инсталяции как BSERVER так и BROUTER высветите "Yes" и нажмите &lt;Enter&gt;. BSETUP будет:</p>
<p>  * Копировать BSERVER.VAP и BROUTER.VAP в директорий SYS\SYSTEM на предпочтительный файл-сервер;</p>
<p>  * Определять программы NetWare Btrieve как объектные в NetWare и присваивать BSERVER заданный Вами пароль. (BROUTER не требует пароля).</p>
<p>Для инсталяции только BSERVER высветите "No" и нажмите &lt;Enter&gt;. BSETUP будет:</p>
<p>  * Копировать BSERVER.VAP в директорий SYS\SYSTEM на предпочтительный файл-сервер;</p>
<p>  * Определять BSERVER как объектный в NetWare и присваивать заданный Вами пароль.</p>
<p>Не инсталируйте BROUTER, если Вы не используете другой VAP для Btrieve-обращений (такой как NetWare SQL).</p>
<p>5) После того, как Вы инсталировали новые Btrieve программы на</p>
<p>файл-сервере, Вы должны перезапустить файл-сервер для того, чтобы действовала новая конфигурация.</p>
<p>REMOVE BTRIEVE</p>
<p>(Удаление Btrieve)</p>
<p>Опция "Remove Btrieve" удаляет Btrieve программы с файл-сервера,</p>
<p>на котором Вы зарегестрированы в данное время. Как только Вы выполнили эту опцию, Btrieve VAP уже не будут загружены на этом файл-сервере. Вы должны быть зарегистрированы как SUPERVISOR или обладать правами супервизора для удаления Btrieve с файл-сервера.</p>
<p>Для удаления Btrieve с файл-сервера, выполните следующие шаги:</p>
<p>  1. Высветите опцию "Remove Btrieve" и нажмите &lt;Enter&gt;.</p>
<p>Появится подсказка "Remove Btrieve".</p>
<p>2) Высветите "Yes" и нажмите &lt;Enter&gt;.</p>
<p>Когда Вы выберете эту опцию, BSETUP будет:</p>
<p>  * Удалять BSERVER.VAP (и BROUTER.VAP, если он инсталирован) из директория SYS:SYSTEM на предпочтительном файл-сервере:</p>
<p>  * Удалять объектное имя Btrieve и пароль из сети.</p>
<p>------------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;В а ж н о :</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если NetWare SQL определен как объектный модуль в программе</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; связей Btrieve, BSETUP не удалит програмные файлы NetWare</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve. Вы должны удалить програмные файлы NetWare SQL с</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файл-сервера для того, чтобы суметь удалить програмные файлы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; NetWare Btrieve. См. Главу 3 "NetWare SQL User's Manual" для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; дополнительной информации,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ----------------------------------------------------------</p>
<p>ОСТАНОВКА BTRIEVE VAPS</p>
<p>Как только BSERVER и BROUTER активизированы, они остаются резидентными в памяти файл-сервера в течении всего времени работы операционной системы NetWare. Вы не можете удалить их из памяти файл-сервера, если сначала не удалите их с файл-сервера, применяя утилиту BSETUP (см. "REMOVE BTRIEVE" на предыдущих страницах) и затем не перезапустите операционную систему.</p>
<p>Когда Вы запрашиваете команду DOWN на файл-сервере, BSERVER выполняет переустановку всех активных связей сети, имеющих доступ к файлам на файл-сервере.</p>
<p>П Р О Г Р А М М А BREQUEST</p>
<p>(BROUTER не требует пароля). NetWare Btrieve имеет программы BREQUEST для рабочих станций как DOS так и OS/2. В этом разделе описаны опции запуска BREQUEST и инструкции для запуска BREQUEST в обеих средах.</p>
<p>ОПЦИИ ЗАПУСКА BREQUEST</p>
<p>Этот раздел описывает опции запуска BREQUEST и значения, которые Вы можете им присваивать.</p>
<p>[/R:распределеные накопители]</p>
<p>Опция /R указывает максимальное число распределеных накопителей, к которым имеет доступ рабочая станция. Когда Вы опускаете эту опцию, BREQUEST использует значение по умолчанию равное трем. Каждый заданный Вами накопитель увеличивает размер резидентной памяти BREQUEST на 20 байт. Например, если рабочая станция имеет пять распределенных накопителей, задайте опцию /R следующим образом:</p>
<p>/R:5</p>
<p>[/D:длина передаваемых данных]</p>
<p>Опция /D задает длину самой длинной записи, к которой Вы имеете доступ через Btrieve. BREQUEST использует задаваемое Вами здесь значение для вычисления длины буфера передаваемых данных, который он резервирует для передачи данных между BSERVER и Вашей прикладной программой. Значение вводимое здесь должно быть равно максимальной длине записи, что вы конфигурируете для Btrieve через программу BSETUP. См. раздел "Максимальная длина записи" в этой главе.</p>
<p>Значение по умолчанию для опции /D равно 2048 байт. Максимальная длина записи, что Вы можете задать, равна 32KB. Задавая большее значение, Вы не достигнете улучшения выполнения.</p>
<p>BREQUEST поддерживает две копии буфера передаваемых данных. Опция /D увеличивает размер резидентной памяти BREQUEST на удвоенное число заданных Вами байт плюс 538 байт.</p>
<p>Всегда задавайте длину записи в байтах. Например, если самая длинная запись, используемая Вашей программой, имеет длину 3000 байт, задайте опцию /D следующим образом:</p>
<p>/D:3000</p>
<p>[/S:число файл-серверов]</p>
<p>Опция /S задает число файл-серверов, к которым может обратиться рабочая станция. Значение по умолчанию для опции /S равно единице максимальное допустимое значение равно восьми. Например, если рабочая станция имеет накопители, расположенные на трех файл-серверах, задайте опцию /S следующим образом:</p>
<p>/S:3</p>
<p>BREQUEST ДЛЯ РАБОЧИХ СТАНЦИЙ DOS</p>
<p>Вы должны стартовать программу BREQUEST на рабочей станции до того, как рабочая станция сможет иметь доступ к файлам сети Btrieve через BSERVER.VAP Если вы хотите иметь доступ к локальным файлам на рабочей станции, Вы должны загрузить копию Btrieve Record Manager (или Single User или DOS 3.1 Network) до загрузки BREQUEST.</p>
<p>Стартуйте BREQUEST на рабочей станции, выполнив следующую команду:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;Накопитель&gt;BREQUEST[/R:число распределенных накопителей]</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;[/D:длина передаваемых данных]</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;[/S:число файл-серверов]</p>
<p>Замените &lt;Накопитель&gt; именем накопителя, на котором хранится BREQUEST. Вы можете опустить имя накопителя, если BREQUEST хранится на накопителе, заданном по умолчанию, или если BREQUEST расположен в директории Вашего пути поиска.</p>
<p>Опции запуска BREQUEST описаны на предыдущих страницах.</p>
<p>Например, для задания 4 распределенных накопителей, длины передаваемых данных равной 2048 байт и 2 файл-серверов, применяйте следующую команду:</p>
<p>BREQUEST /R:4 /D:2048 /S:2</p>
<p>Для уверенности, что опции запуска всегда загружены, поместите команду BREQUEST в файл AUTOEXEC.BAT на рабочей станции</p>
<p>BREQUEST ДЛЯ РАБОЧИХ СТАНЦИЙ OS/2</p>
<p>BREQUEST.DLL и BTRCALLS.DLL,прграммы динамических связей Btrieve, должны быть инсталированы на раочей станции до того, как рабочая станция сможет иметь доступ к файлам сети Btrieve через BSERVER.VAP. Когда стартует первая прикладная программа Btrieve, OS/2 загружается автоматически.</p>
<p>И н с т а л я ц и я BREQUEST</p>
<p>Для инсталяции BREQUEST для OS/2 скопируйте файлы BREQUEST.DLL и BTRCALLS.DLL с дискеты в:</p>
<p>  * Один из директорий, заданных в команде LIBPATH в файле CONFIG.SYS</p>
<p>  * Корневой директорий загрузочного драйва OS/2.</p>
<p>См. руководство по OS/2 для дополнительной информации о LIBPATH</p>
<p>и об определении размещения библиотек динамических связей.</p>
<p>------------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;В а ж н о :</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; BREQUEST.DLL и BTRCALLS.DLL,прграммы динамических связей,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; поставляемые с NetWare Btrieve, позволяют иметь доступ только</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; к перемещаемым файлам. Прикладная программа на рабочей станции</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; OS/2 не может иметь доступ к локальным файлам с помощью этих</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; программ.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ----------------------------------------------------------</p>
<p>И н и ц и а л и з а ц и я BREQUEST</p>
<p>Вы можете задать опции инициализации, специфические для каждой прикладной программы Btrieve, запускаемой на рабочей станции. BREQUEST использует переменную среды OS/2 REQPARMS для определения опций инициализации, необходимых прикладной программе. Опции инициализации BREQUEST описаны на предыдущих страницах этой главы в разделе "Опции запуска BREQUEST".</p>
<p>Установите опции инициализации BREQUEST, применяя следующую команду среды:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; SET REQPARMS=[/R:число распределенных накопителей]</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;[/D:длина передаваемых данных]</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;[/S:число файл-серверов]</p>
<p>Не делайте пробелов между именем переменной REQPARMS и знаком равенства. Вы можете вставлять пробелы между задаваемыми Вами опциями инициализации.</p>
<p>Например, задавайте 4 распределенных накопителя, длину передаваемых данных в 2048 байт и 2 файл-сервера, применяя следующую команду:</p>
<p>SET REQPARMS=/R:4/D:2048/S:2</p>
<p>Для уверенности, что опции запуска всегда загружены, поместите команду SET REQPARMS в один из специальных загрузочных файлов инициализации, применяемых для OS/2.</p>
<p>ОСТАНОВКА BREQUEST</p>
<p>НА РАБОЧЕЙ СТАНЦИИ DOS существует два метода для удаления BREQUEST из памяти:</p>
<p>  * Ваша прикладная программа может запросить операцию Stop (Btrieve-операция 25).</p>
<p>  * Вы можете запросить команду BUTIL_STOP из командной строки рабочей станции</p>
<p>НА РАБОЧЕЙ СТАНЦИИ OS/2 операционная система удаляет программы динамических связей из памяти, когда завершена последняя прикладная программа Btrieve. Вы не можете удалить программы динамических связей из памяти, пока активна какая-либо прикладная программа Btrieve, т.к. операционная система динамически связываетих с прикладной программой при ее загрузке.</p>
<p>{[logo.gif]} &nbsp;{[eXclusive Banner Network]}{[GooDoo 120]}</p>
<p>{Программы} &#8226;{Железо} &#8226; {Драйверы} &#8226; {Хостинг} &#8226;{Энциклопедия рекламы}</p>
<p>| {&lt;&lt;} | {&lt;} | {&gt;} | {&gt;&gt;}</p>
<p>------------------------------------</p>
<p>ГЛАВА 4. УТИЛИТЫ</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; NetWare Btrieve обеспечивает Вас полным набором утилит,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; помогающим Вам при создании и поддержке файлов, тестировании и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; отладке. Вдобавок, NetWare Btrieve включает некоторые утилиты</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; командных строк, которые позволяют Вам управлять</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; функционированием NetWare Btrieve в Вашей сети.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Три утилиты NetWare Btrieve:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - BUTIL.EXE - программа, содержащая команды позволяющие Вам</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; создавть и управлять файлами данных Btrieve;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - B.EXE (Исполнитель Btrieve-функций) - интерактивная утилита,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; которую Вы можете использовать для обучения, тестирования и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; отладки логики Вашой прикладной программы.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Утилиты Командных Строк - утилиты, позволяющие Вам управлять</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; функционированием NetWare Btrieve в Вашей сети.</p>
<p>ПРОГРАММА BUTIL</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Программа BUTIL содержит полный набор команд для применения при</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; создании, поддержке и восстановлении файлов. Следующие разделы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; описывают, как запускать BUTIL, контролировать сообщения об</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ошибках BUTIL, создавать BUTIL-описания файлов и файлы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; альтернативной последовательности поиска. Команды BUTIL</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; представлены в алфавитном порядке под заголовком "Команды BUTIL"</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ЗАПУСК BUTIL</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для запуска BUTIL выполните следующие шаги:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; 1) Стартуйте программу BREQUEST до запуска BUTIL. Если Вам нужна</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;помощь в этой процедуре, см. "Программа BREQUEST" в Главе 3.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; 2) Введите команду BUTIL в следующем формате:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;Устройство&gt;:BUTIL-COMMAND[Параметры][-O&lt;Владелец&gt;]</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Устройство&gt; именем накопителя или другого устройства,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; содержащего програмные файлы Btrieve. вы можете опустить</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; устройство, если Вы намерены использовать диск, заданный по</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; умолчанию.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените _COMMAND именем Btrieve-команды (COPY, LOAD и т.д.),</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; которую Вы хотите использовать. Вы должны поставить перед</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; командой &nbsp;черточку (-).</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Параметры&gt; информацией, необходимой BUTIL для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; выполнения выбранной Вами команды. Команды описаны под заголовком</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; соответствующей команды.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Владелец&gt; или именем владельца Btrieve-файла, к</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; которому будет иметь доступ команда, или звездочкой (*). Если Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; используете звездочку вместо имени владельца, BUTIL подскажет Вам</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; имя владельца файла. BUTIL требует параметр -O&lt;Владелец&gt;, если</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; какой-либо из Btrieve-файлов, заданных в команде, требует имя</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; владельца.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; BUTIL отбрасывает ведущие пробелы, тем не менее звездочка (*) -</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; первый непробельный символ параметра -O.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если Вы задаете два Btrieve-файла в команде, Вы должны задать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметр -O дважды, по разу для каждого файла. Если только второй</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файл имеет имя владельца, BUTIL игнорирует первое имя владельца.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; вы можете применять опцию "звездочка" дважды.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если Вы введете команду BUTIL без параметров, BUTIL покажет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; правильный формат команды для всех команд. Вы можете</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; переназначить этот выход в файл или на принтер с помощью</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; переназначения DOS.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; СООБЩЕНИЯ ОБ ОШИБКАХ BUTIL</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; BUTIL возвращает сообщения об ошибках двумя способами, в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; зависимости от того, запускаете ли Вы ее из командной строки или</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; из командного файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если какие-либо ошибки появляются во время запуска BUTIL из</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; командной строки, на экране появится сообщение, описывающее</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; проблему. См. Приложение B для информации о сообщениях об ошибках</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; BUTIL и Btrieve.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если какие-либо ошибки появляются во время запуска BUTIL из</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; командного файла, BUTIL вернется на уровень ошибки DOS. Следующая</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; таблица перечисляет и описывает уровни ошибок BUTIL.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Уровень ошибки &nbsp; Описание</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;0 &nbsp; &nbsp; &nbsp; &nbsp; Запуск утилиты завершен без ошибок.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1 &nbsp; &nbsp; &nbsp; &nbsp; Запуск утилиты завершен, но появляются</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;нефатальные ошибки, такой как код статуса</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;5 (Дубликат значения ключа).</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2 &nbsp; &nbsp; &nbsp; &nbsp; Запуск утилиты не завершен из-за</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;появления фатальной ошибки, такой как код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;статуса 2 (ошибка ввода/вывода).</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете проверить уровень ошибки DOS, включая в командном файле</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; после команды BUTIl условие подобное следующему:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;IF ERRORLEVEL n ECHO сообщение</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените n номером уровня ошибки BUTIL. Замените "сообщение"</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; значением сообщения.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Из-за способа, как DOs тестирует уровни ошибок в командах</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; командного файла, Вы всегда должны тестировать уровень ошибки 2</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; первым. Пример части командного файла, приведенный ниже,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; иллюстрирует один из способов анализа уровней ошибки BUTIL.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; BUTIL-LOAD LOADFILE BTRFILE_OOWNERNAME</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; IF ERRORLEVEL 2 ECHO Фатальная ошибка:BUTIL операция не закончена</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; IF ERRORLEVEL 1 ECHO Не фатальная ошибка:Проверте на дубликаты в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;загружаемом файле.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; IF ERRORLEVEL 0 ECHO Операция закончена успешно.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; См. обсуждение командных файлов в руководстве по операционной</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; системе для дополнительной информации о том, как использовать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; условие ERRORLEVEL.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ОПИСАНИЕ ФАЙЛОВ BUTIL</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Некоторые из BUTIL-команд, включая CREATE, SAVE и SINDEX,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; используют ОПИСАНИЕ ФАЙЛА. Описание файла - это последовательный</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ASCII файл, содержащий некоторую информацию, необходимую Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; для выполнения этих операций.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующий раздел описывает элементы, используемые в описаниях</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файлов BUTIL. Раздел, содержащий набор правил, которыми Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; должны руководствоваться при создании описания файла, следует за</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; описанием элементов.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;э л е м е н т о в &nbsp;ф а й л а</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Описание файлов состоит из списка ЭЛЕМЕНТОВ. элемент состоит из</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ключевого слова, за которым следует знак равенства (=), а затем</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; следует значение. Каждый элемент в описании файла соответствует</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; какой-либо характеристике Btrieve-файла или определению ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Полное описание Btrieve-файла и характеристик ключей см. в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Главе 2 "Управление Btrieve-файлами".</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ниже содержится объяснение описаний элементов файла. Описания</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; некоторых элементов файла помечены "необязательное" и могут быть</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; опущены при описании файла, если они не требуются для файла или</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; определения ключа. Элементы представлены в том порядке, в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; котором они должны появляться в описании файла. Под заголовком</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; каждого элемента Вы найдете следующие подзаголовки.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Э л е м е н т &nbsp;- представляет правильный формат ключевого</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; слова элемента. Значение представлено как переменная.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Переменные, представляющие числовые значения, показаны</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; символами nnnn. Другие значения объясняются в тексте,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; сопровождающем описание каждого элемента.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Г р а н и ц а &nbsp;- определяет границы допустимых значений,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; которые Вы можете задать для элемента.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - К о м а н д ы &nbsp; - список команд BUTIL, которым требуется</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; этот элемент в описании файлов.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; За подзаголовками следует краткое описание элемента и как его</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; применять.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ----------------------------------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ПРИМЕЧАНИЕ:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Значения в описаниях элементов заключены в скобки. Не</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; заключайте в скобки значения в Вашем описании файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ----------------------------------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Record Length</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Длина записи)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : record=&lt;nnnn&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Г р а н и ц а : 4-4090</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К о м а н д ы : CREATE</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Record Length" определяет длину логической записи</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; данных в файле. Для записей фиксированной длины это значение</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; должно соответствовать длине параметра буфера данных, что</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; выполняет операции над файлом. Если Вы используете записи</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; переменной длины, задаваемая Вами длина записи должна</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; соответствовать длине фиксированной части записи.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Минимальная длина записи данных должна быть достаточно большой,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; чтобы содержать все определенные для файла ключи, но не меньше</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; четырех байт. Длина записи плюс заголовки ее ключей плюс шесть</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; байтов не должны превышать размер страницы файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Variable Length Records</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Записи переменной длины)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : variable=&lt;y | n&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Г р а н и ц а : нет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К о м а н д ы : CREATE</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Variable Length Records" задает, хотите ли Вы чтобы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файл содержал записи переменной длины.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Задайте "y", если Вы хотите, чтобы создаваемый Вами файл</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; содержал записи переменной длины. Иначе, задайте "n".</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Blank Truncation</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Отсечение пробелов)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : truncation=&lt;y | n&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Г р а н и ц а : нет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К о м а н д ы : CREATE</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Blank Truncation" задает, хотите ли Вы, чтобы Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; выполнял отсечение пробелов у записей переменной длины.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ключевое слово truncation требуется только6 если Вы задаете "y"</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; для записи переменной длины.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Задайте "y", если Вы хотите, чтобы Btrieve использовал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; отсечение пробелов. Иначе, задайте "n".</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Data Compression</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Сжатие данных)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : compress=&lt;y | n&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Г р а н и ц а : нет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К о м а н д ы : CREATE</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Data Compression" задает, хотите ли Вы, чтобы Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; выполнял сжатие данных над записями, добавляемыми в файл.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Задайте "y", если Вы хотите, чтобы Btrieve выполнял сжатие</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; данных. Иначе, задайте "n".</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Key Count</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (счетчик ключа)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : key=&lt;nn&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Г р а н и ц а : 1-24</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К о м а н д ы : CREATE</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Key Count" задает число ключей, определенных для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файла. Если Вы зададите значение 0 для этого элемента, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; создаст файл, состоящий только из данных. Иначе, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; создаст или стандартный Btrieve-файл или файл, состоящий</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; только из ключей, в зависимости от значения, заданного для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; элемента "Include Data".</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для значений больших 0 Вы должны определить по крайней мере</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; 1 ключ, но не более 8, если размер страницы равен 512 байтам.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если размер страницы - 102 байта или больше, Вы можете</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; определить до 24 ключей.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Page Size</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Размер страницы)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : page=&lt;nnnn&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Г р а н и ц а : 512-4096</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К о м а н д ы : CREATE</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Page Size" задает физический размер страницы файла в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; байтах. Вы можете задавать любое число, кратное 512, до 4096.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Page pre-allocation</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Перераспределение страницы)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : allocation=&lt;nnnnn&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Г р а н и ц а : 1-64K</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К о м а н д ы : CREATE</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Page pre-allocation" задает количество страниц,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; которое вы хотите перераспределить в файле. Если Вы не хотите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; перераспределять какие-либо страницы, не включайте это ключевое</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; слово в Ваше описание файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Replace Existing File (необязательный)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Замена существующего файла)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : replace=&lt;y | n&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Г р а н и ц а : нет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К о м а н д ы : CREATE</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Replace Existing File" показывает, что Вы не хотите,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; чтобы Btrieve создавал новый файл, если файл с таким же именем</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; уже существует, и предупредил Вас о существовании файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Задайте "n", если Вы не хотите создавать новый файл вместо</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; существующего файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если Вы хотите заменить существующий Btrieve-файл на новый</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; пустой файл с тем же самым именем, или задайте "y", или не</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; включайте этот элемент в описание файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Include Data (необязательный)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Включение данных)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : data=&lt;y | n&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Г р а н и ц а : нет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К о м а н д ы : CREATE</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Include Data" задает, хотите ли Вы, чтобы Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; создал файл, состоящий только из ключей. Задайте "n", если Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; хотите, чтобы Btrieve создал файл, состоящий только из ключей.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для создания стандартного файла или задайте "y" для элемента</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; "Include Data", или опустите этот элемент в описании файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для создания файла, состоящего только из данных, задайте "y"</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; для элемента "Include Data" и установите элемент "Key Count" в 0</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Free Space Threshold</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Граница свободного пространства)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : fthreshold=&lt;10 | 20 | 30&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Г р а н и ц а : 10%, 20% или 30% от размера страницы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К о м а н д ы : CREATE</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Free Space Threshold" задает величину свободного</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; пространства, которую Вы хотите, чтобы Btrieve зарезервировал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; на странице файла для расширения для записей переменной длины.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Заданное Вами значение выражено в процентах от размера страницы.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Не включайте элемент "Free Space Threshold" в описание файла,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; если файл не допускает записи переменной длины. Если вы задаете</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; "variable=y" и не задаете границу свободного пространства,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve будет использовать значение 5% от размера страницы,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; заданное по умолчанию.</p>
<p>------------------------------------</p>
<p class="note">Примечание:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Следующие элементы определяют информацию о ключах файла. вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;должны вводить информацию о ключах, начиная с позиции ключа,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;для каждого сегмента ключа, что Вы хотите определить.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;-----------------------------------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Key Position</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Позиция ключа)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : position=&lt;nnn&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Г р а н и ц а : 1-&lt;длина записи&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К о м а н д ы : CREATE, INDEX, SINDEX</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Key Position" показывает позицию сегмента ключа в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; записи. Позиция ключа должна быть по крайней мере равна 1 и не</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; может быть больше значения, заданного Вами для длины запсии.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; определяемые Вами ключи могут перекрываться.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Key Length</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Длина ключа)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : length=&lt;nnn&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Г р а н и ц а : 1-&lt;ограничение для типа ключа&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К о м а н д ы : CREATE, INDEX, SINDEX</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Key Lehgth" определяет длину поля ключа или ключевого</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; сегмента. Сумма длины ключа и начальной позиции не должна</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; превышать заданную длину записи файла. длина ключа должна быть</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; показывает позицию сегмента ключа в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; записи. Позиция ключа должна быть по крайней мере равна 1 и не</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; может быть больше значения, заданного Вами для длины запсии.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Определяемые Вами ключи могут перекрываться.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Duplicate Key Values</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Дубликаты значений ключа)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : duplicates=&lt;y | n&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Г р а н и ц а : нет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К о м а н д ы : CREATE, INDEX, SINDEX</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Duplicate Key Values" задает, хотите ли Вы допустить,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; чтобы более чем одна запись в файле содержала одно и то же</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; значение поля ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Задайте "y", если Вы хотите допустить дубликаты значений ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Иначе, задайте "n".</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Modifiable Key Values</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Модифицируемые значения ключа)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : modifiable=&lt;y | n&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Г р а н и ц а : нет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К о м а н д ы : CREATE, INDEX, SINDEX</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Modifiable Key Values" задает, хотите ли Вы позволить</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; прикладной программе модифицировать значение ключа во время</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операции Update.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Задайте "y", если Вы хотите, чтобы значения этого ключа были</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; модифицируемыми. Иначе, задайте "n".</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Key Type</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Тип ключа)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : type=&lt;значение типа ключа&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Г р а н и ц а : Любой из типов Btrieve-ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К о м а н д ы : CREATE, INDEX, SINDEX</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Key Type" задает тип данных для ключа. Вы можете</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; задать все слово (такое как "float") или только первые две буквы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; слова ("fl" для типа float). См. Приложение G для дополнительной</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; информации о типах ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Descending Sort Order (необязательный)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Убывающий порядок сортировки</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : descending=y</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Г р а н и ц а : нет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К о м а н д ы : CREATE, INDEX, SINDEX</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Descending Sort Order" задает, хотите ли Вы, чтобы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve сортировал индекс в убывающем порядке.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Включите элемент "Descending Sort Order" &nbsp;и задайте "y", если Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; хотите, чтобы Btrieve сортировал значения ключа в убывающем</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; порядке. Если Вы не включите этот элемент, Btrieve отсортирует</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; значения ключа в возрастающем порядке.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Alternate Collating Sequence</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Альтернативная последовательность поиска)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : alternate=&lt;y | n&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Г р а н и ц а : нет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К о м а н д ы : CREATE, INDEX, SINDEX</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Alternate Collating Sequence" задает, хотите ли Вы,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; чтобы сортировка данных осуществлялась в последовательности,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; отличающейся от стандартной ASCII последовательности. Это</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; полезно, если вы хотите применять алфавит, отличный от</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; английского, или если вы хотите просматривать символы нижнего</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; регистра как символы верхнего регистра.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете задать альтернативную последовательность поиска только</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; для ключей типа string, lstring или zstring (строка, l-строка или</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; z-строка). Если Вы хотите, чтобы Btrieve сортировал индекс с</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; помощью альтернативной последовательности поиска, введите "y" в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; это поле. Иначе, задайте "n".</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Manual Key (необязательный)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Ручной ключ)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : manual=&lt;y | n&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Г р а н и ц а : нет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К о м а н д ы : CREATE, INDEX, SINDEX</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Manual Key" задает, что определяемый Вами ключ или</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; сегмент ключа - ручной. Если вы определите сегмент ключа как</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ручной, Вы должны задать пустое значение для этого сегмента.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если ключ - сегментированный ключ и Вы определяете один сегмент</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; как ручной, Вы должны определить все сегменты как ручные.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Null Key</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Пустой ключ)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : null=&lt;y | n&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Г р а н и ц а : нет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К о м а н д ы : CREATE, INDEX, SINDEX</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Null Key" задает, должен ли определяемый Вами ключ</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; иметь пустое значение. Если Вы определяете пустое значение для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; одного сегмента сегментированного ключа, Вы должны определить</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; пустое значение для всех сегментов этого сегментированного ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Пустые значения, определяемые Вами для каждого сегмента, могут</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; быть разными.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; вы можете включить элемент "Null Key" в файл-описание для команды</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; INDEX. Однако, INDEX не рассматривает какое-либо заданное Вами</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; пустое значение. BUTIL допускает его для поддержки постоянных</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; форматов для файлов-описаний CREATE, INDEX и SINDEX.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Задайте "y", если Вы хотите определить пустое значение для этого</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ключа. Иначе, задайте "n".</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Null Key Value</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Пустое значение ключа)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : value=&lt;nnn&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Г р а н и ц а : любое 1-байтовое шестнадцатиричное значение</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К о м а н д ы : CREATE, INDEX, SINDEX</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Null Key value" задает в шестнадцатиричном виде</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; значение, которое Вы хотите, чтобы Btrieve распознавал как пустой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; символ для ключа. Типичные пустые значения - 20 как пробел и 0</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; как двоичный ноль. &nbsp;Включайте этот элемент только, если Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; определяете ключ как допускающий пустые значения. Если Вы задаете</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; "n" для элемента " Null Key", не включайте элемент</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; "Null Key Value" в файл-описание.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Segmented Key</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Сегментированный ключ)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : segment=&lt;y | n&gt;</p>
<p>Г р а н и ц а : нет</p>
<p>К о м а н д ы : CREATE, INDEX, SINDEX</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Segmented Key" задает, имеет ли определяемый Вами ключ</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; еще какие-либо сегменты.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Задайте "y", если ключ имеет другой сегмент. Задайте "n", если</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы определяете несегментированный ключ или последний сегмент</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; сегментированного ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Alternate Collating Sequence Filename</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Имя файла альтернативной последовательности поиска)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Э л е м е н т : name=&lt;имя файла&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Г р а н и ц а : имя файла</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К о м а н д ы : CREATE, INDEX, SINDEX</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Элемент "Alternate Collating Sequence Filename" задает имя файла,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; содержащего альтернативную последовательнось для создоваемого</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вами файла7 вы можете включать любое число уровней директорий в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; имени файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если вы задаете элемент "Alternate Collating Sequence Filename",</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; не включайте это ключевое слово в Ваш файл-описание.</p>
<p>П р а в и л а д л я ф а й л о в - о п и с а н и й</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующие правила применяются к файлам-описаниям BUTIL. Если</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; BUTIL возвращает ошибку при попытке получить доступ к файлу-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; описанию, произведите проверку в следующих областях.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Все элементы такие, как "type=fl", должны быть написаны</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; символами нижнего регистра.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Все элементы должны быть написаны правильно и отделены от</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; предыдущих элементов "белым пробелом" (т.е. пробелом,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; символом табуляции, CR/LF и т,д,)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Элементы должны быть представлены в файле-описателе в том</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; порядке, в каком они представлены в предыдущем разделе.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Ответы должны соответствовать друг другу. Например, если Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; задаете "null=y' для элемента "Null Key", должен появиться и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; элемент "Null Key Value" и его значение; иначе их не должно</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; быть. Если Вы задаете "alternate=y" для элемента "Alternate</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Collating Sequence" в одном или более сегментов ключа,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; элемент "Alternate Collating Sequence Filename" и полное или</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; относительное имя пути файла альтернативной</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; последовательности поиска должны быть представлены как</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; последний элемент файла-описания.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Удостоверьтесь, что существует достаточное количество</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; описаний ключей для формирования числа ключей, заданных в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; элементе "Key Count". Вводите информацию о ключе, начиная с</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; позиции ключа, для каждого сегмента ключа в файле.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Удостоверьтесь, что файл-описание не содержит символов</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; форматирования текста. (Некоторые текстовые процессоры</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; помещают символы форматирования в текстовый файл. Файл-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; описание не долженсодержать никакие символы форматирования).</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - BUTIL не проверяет на конец файл-описание. Если Вы не задали</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; альтернативную последовательность поиска, возможно включить</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; слишком много описаний ключей и не получить сообщения об</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ошибке. Вы можете включать коментарии в конце файла-описания</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; после всех описаний ключей и элемента "Alternate Collating</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Sequence Filename".</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Оббратите внимание, что файлы-описания для CREATE, INDEX и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; SINDEX имеют слегка различные форматы.</p>
<p>  &nbsp; &nbsp;ФАЙЛЫ АЛЬТЕРНАТИВНОЙ</p>
<p>  &nbsp; &nbsp;ПОСЛЕДОВАТЕЛЬНОСТИ &nbsp;ПОИСКА</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Первые 265 байт файла альтернативной последовательности поиска</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; содержат определение последовательности поиска, отличной от</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; стандартной ASCII последовательности. Если Вы хотите создать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файл альтернативной последовательности поиска, Вы должны написать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; прикладну программу, генерирующую файл в заданном ниже формате.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Смещение &nbsp; &nbsp;Длина &nbsp; &nbsp;Описание</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 0 &nbsp; &nbsp; &nbsp; &nbsp; 1 &nbsp; &nbsp; &nbsp;Байт знака. Этот байт должен всегда</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;содержать шестнадцатиричное значение AC.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 1 &nbsp; &nbsp; &nbsp; &nbsp; 8 &nbsp; &nbsp; &nbsp;8-байтовое имя, которое однозначно</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;идентифицирует альтернативную</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;последовательность поиска для Btrieve.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 9 &nbsp; &nbsp; &nbsp; &nbsp;256 &nbsp; &nbsp; 256-байтовая таблица, содержащая</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;значение сортировки для каждого символа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Храните значение для каждого символа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;сортировки со смещением, соответствующим</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;представлению символа в ASCII</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;последовательности поиска. Например, для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;сортировки символа A как чего-то другого</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;чем 0x41, храните новое значение</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;сортировки со смещением 0x41 в этой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;таблице.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Например, если вы хотите вставить символ с шестнадцатиричным</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; значением 5D между буквами U (шестнадцатиричное 55) и V</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (шестнадцатиричное 56) в Вашей последовательности, байт 5D в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; этой последовательности будет содержать значение 56, а байты</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; 56-5C в этой последовательности будет содержать значения 57-5D.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Файл UPPER.ALT, который Вы найдете на Вашей програмной дискете,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; содержит пример альтернативной последовательности поиска. Эта</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; частная последовательность сравнивает символы верхнего и нижнего</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; регистра так, как будто они бы были все в верхнем регистре. Если</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы имеете множество файлов с различными альтернативными</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; последовательностями поиска, все последовательности должны иметь</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; различные имена.</p>
<p>КОМАНДЫ BUTIL</p>
<p>Следующие разделы описывают, как применять команды BUTIL:</p>
<p>Команда Функция</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;CLONE &nbsp; &nbsp; &nbsp; &nbsp;Создает пустой Btrieve-файл с теми же самыми</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; спецификациями, что и у существующего файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;COPY &nbsp; &nbsp; &nbsp; &nbsp; Копирует содержимое одного Btrieve-файла в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; другой Btrieve-файл</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;CREATE &nbsp; &nbsp; &nbsp; Создает Btrieve-файл</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;DROP &nbsp; &nbsp; &nbsp; &nbsp; Отбрасывает дополнительный индекс</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;EXTEND &nbsp; &nbsp; &nbsp; Создает разделенный файл</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;INDEX &nbsp; &nbsp; &nbsp; &nbsp;Создает внешний индексный файл</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;LOAD &nbsp; &nbsp; &nbsp; &nbsp; Загружает содержимое стандартного</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; последовательного файла в Btrieve-файл</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;RECOVER &nbsp; &nbsp; &nbsp;Восстанавливает данные поврежденого</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Btrieve-файла</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;RESET &nbsp; &nbsp; &nbsp; &nbsp;Закрывает файлы данных и освобождает ресурсы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;SAVE &nbsp; &nbsp; &nbsp; &nbsp; Сохраняет содержимое Btrieve-файла в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; стандартном последовательном файле</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;SINDEX &nbsp; &nbsp; &nbsp; Создает дополнительный индекс</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;STAT &nbsp; &nbsp; &nbsp; &nbsp; Показывает статистику по атрибутам и текущим</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; размерам файла</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;STOP &nbsp; &nbsp; &nbsp; &nbsp; Завершает BREQUEST и локальный Record Manager</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (если он заружен) и удаляет их из памяти</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;VER &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Показывает версию Btrieve и номера пересмотра</p>
<p>CLONE</p>
<p>Ф о р м а т к о м а н д ы</p>
<p>BUTIL-CLONE &lt;Существующий файл&gt;&lt;Новый файл&gt;[-O &lt;Владелец&gt;]</p>
<p>О п и с а н и е</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Команда CLONE создает новый пустой Btrieve-файл с теми же сам</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; спецификациями файла, включая дополнительные индексы,что и у</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; существующего файла. Вы можете применять CLONE, когда Вы хотите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; заменить существующий файл, но не хотите разрушать информацию,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; содержащуюся в существующем файле, как это происходит при</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; применении Вами операции CREATE. Вдобавок, CLONE не требует</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файла-описания для создания нового файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К а к &nbsp; п р и м е н я т ь &nbsp; CLONE</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для запуска CLONE введите команду в показанном выше формате.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вместо &lt;Существующий файл&gt; введите имя Btrieve-файла, который Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; хотите получить. Вы можете задать полное имя пути, если</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; требуется.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вместо &lt;Новый файл&gt; введите имя, которое Вы хотите использовать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; для нового пустого Btrieve-файла. Вы можете задать полное имя</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; пути, если требуется.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вместо &lt;Владелец&gt; введите имя владельца существующего файла,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; если оно требуется. Новый файл будет с именем владельца</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; существующего файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е р</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующая команда получает файл NEWINV08-14-92T из файла INVOICE08-14-92T</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Имя владельца файла INVOICE08-14-92T - "Sandy"</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BUTIL-CLONE INVOICE08-14-92T NEWINV08-14-92T -O Sandy</p>
<p>COPY</p>
<p>Ф о р м а т к о м а н д ы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BUTIL-COPY &lt;Входной файл&gt;&lt;Выходной файл&gt;[-O &lt;Владелец1&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [-O&lt;Владелец2&gt;]]</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Команда COPY копирует содержимое одного Btrieve-файла в другой.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Наиболее общее применение COPY - изменение характеристик ключей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (таких как позиция ключа, длина ключа или значения ключей-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; дубликатов) Btrieve-файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; COPY берет каждую запись из входного файла и вставляет ее в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; выходной файл, используя операции Btrieve Get и Insert. COPY</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; выполняет за один шаг ту же самую функцию, что и SAVE и следуемая</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; за ней LOAD.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К а к &nbsp; п р и м е н я т ь &nbsp; COPY</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для запуска COPY введите команду в показанном выше формате.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Входной файл&gt; на имя Btrieve-файла, из которого Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; пересылаете записи. Вы можете задать полное имя пути, если</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; требуется.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Выходной файл&gt; на имя Btrieve-файла, в который Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; хотите вставить записи. Файл может быть как пустой, так и нет.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете задать полное имя пути, если требуется.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Владелец1&gt; и &lt;Владелец2&gt; именами владельцев Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файлов, если требуется. Если &lt;Входной файл&gt; требует имя владельца</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете задать имя для &lt;Владелец1&gt; или использовать опцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; "звездочка", описанную в начале этой главы. Если &lt;Выходной файл&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; требует имя владельца, испоьзуйте обе опции &lt;Владелец1&gt; и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &lt;Владелец2&gt;. Если выходной файл не требует имя владельца, Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; можете оставить пробел вместо &lt;Владелец1&gt;. Используйте</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &lt;Владелец2&gt; для задания имени владельца для &nbsp;&lt;Выходной файл&gt;.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; После того6 как записи были скопированы из входного файла в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; выходной файл, COPY отобразит на экране суммарное число</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; скопированных записей.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е р</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующая команда копирует записи из файла CUSTOMER08-14-92T в файл</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ACCTRECV08-14-92T . Файл CUSTOMER08-14-92T не требует имя владельца.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Файл ACCTRECV08-14-92T имеет имя владельца "Pam".</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BUTIL-COPY CUSTOMER08-14-92T ACCTRECV08-14-92T -O -O Pam</p>
<p>CREATE</p>
<p>Ф о р м а т к о м а н д ы</p>
<p>BUTIL-CREATE &lt;Новое имя файла&gt;&lt;Файл-описание&gt;</p>
<p>О п и с а н и е</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Команда CREATE генерирует пустой Btrieve-файл, используя</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; характеристики заданные в файле-описании.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К а к &nbsp; п р и м е н я т ь &nbsp; CREATE</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Вы сможете запустить CREATE, Вы должны сперва</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; сгенерировать файл-описание в текстовом редакторе. Файлы-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; описанияля описаны в "Файлы-описания BUTIL".</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для запуска CREATE введите команду в показанном выше формате.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Новое имя файла&gt; на имя файла, который Вы хотите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; создать. Вы можете задать полное имя пути, если требуется.</p>
<p>------------------------------------</p>
<p class="note">Примечание:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Если имя, заданное в &lt;Новое имя файла&gt; - имя существующего</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Btrieve-файла, BUTIL создаст новый пустой файл вместо</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;существующего файла. Все данные, хранящиеся в существующем</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;файле, будут потеряны и их нельзя будет восстановить.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;-----------------------------------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вместо &lt;Файл-описание&gt; введите имя файла-описания, содержащего</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; спецификации для нового файла. Вы можете задать полное имя пути,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; если требуется.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е р &nbsp; файла-описания для BUTIL-CREATE</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Файл-описание, показанный на Рисунке 3.1, создает Btrieve-файл с</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; размером страницы 512 байт и двумя ключами. Фиксированная часть</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; записи - длиной 98 байт. Файл допускает записи переменной длины,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; но не использует отсечение пробелов. Файл использует сжатие</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; данных. Граница свободного пространства установлена на 20%.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve будет перераспределять 100 страниц при создании файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Первый ключ (Ключ 0) - сегментированный ключ с двумя допускающими</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; дубликаты, немодифицируемыми, строковыми сегментами с</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; альтернативной последовательностью поиска, определенной в файле</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; UPPER.ALT, и с пробелом вместо пустого значения. Второй ключ</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Ключ 2) - числовой ключ без сегментов, не допускающий дубликатов</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; но позволяющий модификацию. Он отсортирован в убывающем порядке.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp;record=98 variable=y truncation=n</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Спецификации файла { &nbsp; &nbsp;compress=y key=2 page=512</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp;allocation=100 replace=n fthreshold=20</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp;position=1 length=5 duplicates=y</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Ключ 0, сегмент 1 &nbsp;{ &nbsp; &nbsp;modifiable=n type=string alternate=y</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp;null=y value=20 segment=y</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp;position=6 length=10 duplicates=y</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Ключ 0, сегмент 2 &nbsp;{ &nbsp; &nbsp;modifiable=n type=string alternate=y</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp;null=y value=20 segment=n</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp;position=16 length=2 duplicates=n</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Ключ 1 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; { &nbsp; &nbsp;modifiable=y type=numeric</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp;descending=y alternate=n null=n</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp;segment=n</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Имя файла &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;|</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;альтернативной &nbsp; &nbsp; { &nbsp; &nbsp;name=UPPER.ALT</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;последовательности |</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;поиска &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; |</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Рисунок 1.3</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Пример файла-описания для CREATE</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е р</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующая команда создает Btrieve-файл по имени ACCTS.NEW,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; используя описание, обеспечиваемое файлом-описанием BUILD.DES</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BUTIL-CREATE ACCTS.NEW BUILD.DES</p>
<p>DROP</p>
<p>Ф о р м а т к о м а н д ы</p>
<p>BUTIL-DROP &lt;Btrieve-файл&gt;&lt;Номер ключа&gt;[-O &lt;Владелец&gt;]</p>
<p>О п и с а н и е</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете применять команду DROP для удаления дополнительного</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; индекса из Btrieve-файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve обновляет номер ключа других дополнительных индексов,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; если требуется, до завершения команды DROP.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К а к &nbsp; п р и м е н я т ь &nbsp; DROP</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для запуска DROP введите команду в показанном выше формате.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Btrieve-файл&gt; на имя Btrieve-файла, из которого Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; удаляете индекс. Вы можете задать полное имя пути, если</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; требуется.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Номер ключа&gt; на номер дополнительного индекса, который</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы хотите отбросить.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Владелец&gt; именем владельца файла, если он существует.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е р</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующий пример отбрасывает ключ с номером 6, дополнительный</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; индекс, из файла MAILER.ADR Имя владельца файла - "Sales".</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BUTIL-DROP MAILER.ADR 6 -O Sales</p>
<p>EXTEND</p>
<p>Ф о р м а т к о м а н д ы</p>
<p>BUTIL-EXTEND &lt;Btrieve-файл&gt;&lt;Расширение файла&gt;[-O &lt;Владелец&gt;]</p>
<p>О п и с а н и е</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Когда Вы создаете Btrieve-файл, Вы можете определять файл только</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; для одного тома. EXTEND позволяет Вам расширять существующий</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файл на два логических диска. Этот пункт полезен, когда данные,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; содержащиеся в одном файле, превышают физическую память одного</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; диска или максимальный размер тома, поддерживаемый операционной</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; системой.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К а к &nbsp; п р и м е н я т ь &nbsp; EXTEND</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для запуска EXTEND введите команду в показанном выше формате.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Btrieve-файл&gt; на имя Btrieve-файла, который Вы хотите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; расширить. Вы можете задать полное имя пути, если требуется.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Расширение файла&gt; на имя, которое Вы хотите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; использовать для расширения файла. Обязательно включите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; спецификацию устройства для нового устройства. Устройство должно</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; отличаться от заданного Вами для первоначального файла. Вы можете</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; задать полное имя пути, если требуется.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Владелец&gt; именем владельца файла, если он существует.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если файл расширяется на два диска, Вы должны загрузить оба диска</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; до того, как Вы получите доступ к файлу. Более того, Вы должны</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; загружать расширение файла на то же устройство, что Вы задавли</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; при первом расширении файла. После того, как файл был расширен,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; нельзя выполнить обратную операцию.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е р</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующий пример расширяет файл MAILER.ADR в файл MAILER2.ADR в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; директорий \SALES устройства E. Имя владельца файла - "Sales".</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BUTIL-EXTEND MAILER.ADR E:\SALES\MAILER2.ADR -O Sales</p>
<p>INDEX</p>
<p>Ф о р м а т к о м а н д ы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BUTIL-INDEX &lt;Btrieve-файл&gt;&lt;Индексный файл&gt;&lt;Файл-описание&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;[-O &lt;Владелец&gt;]</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Команда INDEX строит внешний индексный файл, опираясь на поле,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; которое Вы предварительно не задали как ключ. Записи в новом</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файле состоят только из 4-байтового адреса каждой записи в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; первоначальном Btrieve-файле, за которым следует значение, по</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; которому Вы хотите сортировать.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; После того, как Btrieve создал внешний индекс, Вы можете</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; использовать внешний индекс для поиска записей данных в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; первоначальном файле двумя способами:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вы можете применять команду SAVE для поиска записей файла,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; используя внешний индексный файл. См. обсуждение команды SAVE</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; для дополнительной информации.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вы можете создать прикладную программу, которая исследует</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; файл, используя внешний индекс. Прикладная программа должна</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; сперва найти 4-байтовый адрес, используя значение ключа из</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; индексного файла. Ваша прикладная программа может затем искать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; запись из первоначального файла, используя 4-байтовый адрес в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; операции Get Direct.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К а к &nbsp; п р и м е н я т ь &nbsp; INDEX</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Вы сможете построить внешний индекс, применяя</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; команду INDEX, Вы должны создать файл-описание для задания</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; характеристик нового ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для запуска INDEX введите команду в показанном выше формате.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Btrieve-файл&gt; на имя существующего Btrieve-файла, для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; которого Вы хотите построить внешний индекс. Вы можете задать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; полное имя пути, если требуется.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Индексный файл&gt; на имя файла, в котором Btrieve должен</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; хранить внешний индекс. Вы можете задать полное имя пути, если</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; требуется.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;-----------------------------------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ПРИМЕЧАНИЕ:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Так как и файл-оригинал, и индексный файл могут иметь</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;соответствующие прообразы, Вы не должны использовать одно и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;то же имя файла с двумя различными расширениями.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;-----------------------------------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вместо &lt;Файл-описание&gt; введите имя создаваемого файла,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; содержащее определение нового ключа. Файл должен содержать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; определение каждого сегмента нового ключа. Вы можете задать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; полное имя пути, если требуется. См. "Файлы-описания BUTIL" для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; полной информации о файлах-описаниях.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Владелец&gt; именем владельца файла, если он существует.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е р &nbsp; файла-описания для BUTIL-INDEX</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Например, файл-описание на Рисунке 4.2 определяет новый ключ с</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; одним сегментом. Ключ начинается в 30-ом байте записи и имеет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; длину в 10 байтов. Он допускает дубликаты, модифицируемый,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; строкового типа и не использует альтернативную последовательность</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; поиска.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;position=30 length=10 duplicates=y modifable=y type=string</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;alternate=n segment=n</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; После того, как Вы определили ключ для внешнего файла, INDEX</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; создает файл. После создания файла INDEX отобразит на экране</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; количество проиндексированных записей.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е р</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующая команда создает внешний индексный файл QUICKREF.IDX</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; для файла CUSTOMER08-14-92T Файл CUSTOMER08-14-92T не требует имя</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; владельца. Файл-описание, содержащий определение нового ключа, -</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; NEWIDX.DES.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BUTIL-INDEX CUSTOMER08-14-92T QUICKREF.IDX NEWIDX.DES</p>
<p>LOAD</p>
<p>Ф о р м а т к о м а н д ы</p>
<p>BUTIL-LOAD &lt;Входной файл&gt;&lt;Btrieve-файл&gt;[-O &lt;Владелец&gt;]</p>
<p>О п и с а н и е</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Команда LOAD позволяет Вам добавлять записи из последовательного</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файла в Btrieve-файл без создания специально для этой цели</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; прикладной программы. LOAD также обеспечивает удобный способ</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; передачи записей из последовательного файла, созданного другой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; программой, в Btrieve-файл. LOAD не выполняет преобразования</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; данных в загружаемом файле.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; После того, как Btrieve передаст записи, он отобразит на экране</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; суммарное число записей, загруженных в Btrieve-файл.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К а к &nbsp; п р и м е н я т ь &nbsp; LOAD</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Вы запустите команду LOAD, Вы должны создать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; последовательный файл, содержащий новые записи. Вы можете</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; создать файл, применяя стандартный текстовый редактор или</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; прикладную программу.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для запуска команды LOAD ведите команду в показанном выше формате.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Входной файл&gt; на имя последовательного файла,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; содержащего записи для загрузки в Btrieve-файл. Вы можете задать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; полное имя пути, если требуется.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Btrieve-файл&gt; на имя Btrieve-файла, в который Вы хотите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; добавлять записи. Вы можете задать полное имя пути, если</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; требуется.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Владелец&gt; именем владельца Btrieve-файла, если он</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; существует.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; LOAD ожидает, что каждая запись в &lt;Входной файл&gt; будет в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; следующем формате:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Первые n байтов должны быть длиной записи в ASCII.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ДЛЯ ФАЙЛОВ С ЗАПИСЯМИ ФИКСИРОВАННОЙ ДЛИНЫ задаваемая длина</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; должна всегда равняться длине записи, задаваемой Вами при</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; создании файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ДЛЯ ФАЙЛОВ С ЗАПИСЯМИ ПЕРЕМЕННОЙ ДЛИНЫ задаваемая длина</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; должна быть по крайней мере равна минимальной фиксированной</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; длине записи, задаваемой Вами при создании файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - За длиной должен следовать один символ-разделитель (или</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; запятая, или пробел).</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - За разделителем должны следовать сами данные. Длина данного</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; должна быть в точности равна длине, заданной в начале записи</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Запись должна завершаться возвратом каретки/переводом строки</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (шестнадцатеричному 0D0A )</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Последняя запись в файле должна содержать символ конца файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (Ctrl-Z или шестнадцатеричное 1A). большинство текстовых</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; редакторов и команда SAVE автоматически вставляют этот символ</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; в файл.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете создавть Ваш входной файл с помощью текстового</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; редактора или прикладной программы.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ЕСЛИ ВЫ ИСПОЛЬЗУЕТЕ ТЕКСТОВЫЙ РЕДАКТОР ПРИ СОЗДАНИИ ЗАГРУЖАЕМОГО</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ВАМИ ФАЙЛА, удостоверьтесь, что Вы дополнили каждую запись</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; пробелами для достижения заданной вами в начале записи длины.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Поля, содержащие двоичные данные, не могут быть отредактированы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; большинством текстовых редакторов.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ЕСЛИ ВЫ ИСПОЛЬЗУЕТЕ ПРИКЛАДНУЮ ПРОГРАММУ ПРИ СОЗДАНИИ</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ЗАГРУЖАЕМОГО ВАМИ ФАЙЛА, удостоверьтесь, что Вы добавили в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; каждую запись возврат каретки и перевод страницы и включили</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; конец файла в запись. Последовательные запросы ввода/вывода,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; обеспечиваемые большинством процессоров языков высокого уровня,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; добавляют автоматически символы возврата каретки, перевод строки</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; и конца файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Рисунок 4.3 иллюстрирует правильный формат каждой записи в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; выходном файле. Допустим, что Btrieve-файл не допускает записи</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; переменной длины и имеет длину записи, равную 40 байт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;40,Запись за разделителем "запятая". &lt;CR/LF&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &#166; &nbsp; \________________________/ &nbsp; &nbsp;&#166; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; L- Возврат каретки/</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Данное &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp;перевод строки</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; L- 1 пробел для дополнения</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;до соответствующей длины</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; L------ Разделитель "запятая"</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;L-------- Длина записи</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Рисунок 4.3</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Формат записи для выходного файла</p>
<p>П р и м е р</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующий пример загружает последовательные записи из файла</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; MAILT в файл MAILER08-14-92T. Имя владельца для файла MAILER.ADR -</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; "Sales".</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BUTIL-LOAD MAILT MAILER.ADR -O Sales</p>
<p>RECOVER</p>
<p>Ф о р м а т к о м а н д ы</p>
<p>BUTIL-RECOVER &lt;Btrieve-файл&gt; &lt;Выходной файл&gt; [-O &lt;Владелец&gt;]</p>
<p>О п и с а н и е</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Команда RECOVER читает записи из заданного Btrieve-файла,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; используя операции Step, и создает последовательный файл,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; совместимый с командой LOAD. Каждая запись заканчивается</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; возвратом каретки и переводом строки (шестнадцатиричное 0D0A).</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Файл завершается концом файла (шестнадцатиричное 1A).</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете применять RECOVER для поиска данных из поврежденного</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve-файла. Например, файл может быть поарежден при сбое</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; системы во время доступа к файлу в ускоренном режиме. Команда</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; RECOVER сможет найти многие, а возможно и все, записи из файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете затем использовать команду LOAD для добавления записей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; в новый неповрежденный Btrieve-файл.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К а к &nbsp; п р и м е н я т ь &nbsp; RECOVER</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для запуска команды RECOVER введите команду в показанном выше</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; формате.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Выходной файл&gt; на имя файла, где RECOVER будет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; сохранять восстановленные записи. Вы можете задать полное имя</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; пути, если требуется.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Btrieve-файл&gt; на имя Btrieve-файла, который Вы хотите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; восстановить. Вы можете задать полное имя пути, если требуется.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Владелец&gt; именем владельца Btrieve-файла, если он</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; существует.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; После того, как RECOVER найдет записи, она отобразит на экране</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; общее число восстановленных записей. Если логическое устройство,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; содержащее Ваш выходной файл, будет заполнено до того, как весь</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файл будет восстановлен, RECOVER остановится, отобразит</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; количество уже восстановленных записей и затем выдаст следующее</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; сообщение:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Disk volume is full. Enter new file name to continue</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;or . to quit, then press &lt;ENTER&gt;.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (Том диска заполнен. Введите имя нового файла для продолжения</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;или . для выхода, затем нажмите &lt;ENTER&gt;.)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для продолжения операции в другой выходной файл выполните одну из</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; следующих инструкций:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - ЕСЛИ ВЫ ВОССТАНАВЛИВАЕТЕ BTRIEVE-ФАЙЛ НА ДИСКЕТУ, уберите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; полную дискету и замените ее другой отформатированной</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; дискетой.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - ЕСЛИ ВЫ ВОССТАНАВЛИВАЕТЕ BTRIEVE-ФАЙЛ НА ВИНЧЕСТЕР, задайте</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; другое логическое устройство, имеющее свободное пространство.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; В обоих случаях введите имя файла, который Вы хотите, чтобы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve использовал для продолжения хранения записей и нажмите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; клавишу Enter. Btrieve продолжит копирование записей из Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файла в новый выходной файл.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если логическое устройство заполнено, а Вы хотите завершить</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операцию RECOVER, введите точку (.) и нажмите &lt;Enter&gt;.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е р</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующий пример ищет записи из файла MAILER.ADR загружает их в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; последовательный файл файл MAILT. Имя владельца для файла</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; MAILER.ADR - "Sales".</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BUTIL-RECOVER MAILER.ADR MAILT -O Sales</p>
<p>RESET</p>
<p>Ф о р м а т к о м а н д ы</p>
<p>BUTIL-RESET &lt;Номер связи&gt;</p>
<p>О п и с а н и е</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; RESET выполняет Btrieve-операцию Reset для освобождения ресурсов</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; используемых BREQUEST и Record Manager на рабочей станции. Она</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; освобождает все захваты, отменяет все незавершенные транзакции и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; закрывает все открытые файлы станции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете освобождать рескрсы и чужой станции, введя номер связи</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; станции &lt;Номер связи&gt;. Если Вы не знаете номер связи, консольные</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; команды B ACTIVE, WHOAMI и USERLIST возвращают номера связей как</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; часть своего выхода.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К а к &nbsp; п р и м е н я т ь &nbsp; RESET</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для запуска команды RESET введите команду в показанном выше</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; формате.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете запросить эту команду с любой рабочей станции сети, на</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; которую загружен BREQUEST. Если Вы не задали номер станции,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; BUTIL-RESET освободит ресурсы данной станции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е р</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующий пример освобождает ресурсы рабочей станции, используя</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; номер связи 12 сети.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BUTIL-RESET 12</p>
<p>SAVE</p>
<p>Ф о р м а т к о м а н д ы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BUTIL-SAVE &lt;Btrieve-файл&gt; &lt;Выходной файл&gt; &lt;Индекс(Y/N)&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [&lt;Индексный файл&gt; |&lt;Номер ключа&gt;][-O&lt;Владелец&gt;]</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; SAVE позволяет Вам искать записи из Btrieve-файлов и хранить их в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; отсортированном порядке в последовательном файле. Это - точная</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; инверсия LOAD. Эта команда может быть использована в дополнение к</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; LOAD так, что данные из Btrieve-файла могут быть легко извлечены,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; отредактированы и затем сохранены в другом Btrieve-файле.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; SAVE генерирует одну запись в выходном файле идля каждой записи,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; читаемой из Btrieve-файла. Каждая запись начинается со своей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; длины и заканчивается возвратом каретки и переводом строки</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (0D0AH). Файл завершается концом файла (1AH) и совместим с</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; большинством текстовых редакторов. SAVE не выполняет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; преобразования данных в записях. Поэтому, если Вы используете</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; текстовый редактор для модификации выходного файла, содержащего</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; двоичные данные, результат может быть непредсказуем.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; После того, как SAVE завершит этот процесс, на экране будет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; отображено суммарное число сохраненных записей.</p>
<p>К а к п р и м е н я т ь SAVE</p>
<p>Для запуска SAVE введите команду в показанном выше формате.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Btrieve-файл&gt; на имя Btrieve-файла, содержащего записи</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; для сохранения. Вы можете задать полное имя пути, если</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; требуется.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Выходной файл&gt; на имя последовательного файла, в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; котором Вы хотите, чтобы Btrieve хранил записи. Вы можете задать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; полное имя пути, если требуется.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Применяйте один из следующих методов для задания порядка, в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; котором Вы хотите, чтобы SAVE хранила записи:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - ЕСЛИ ВЫ ХОТИТЕ СОХРАНИТЬ ЗАПИСИ С ПОМОЩЬЮ ВНЕШНЕГО ИНДЕКСА,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; задайте Y для &lt;Индекс (Y/N)&gt; и замените &lt;Индексный файл&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; именем внешнего индексного файла. Вы можете задать полное имя</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; пути, если требуется.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - ЕСЛИ ВЫ ХОТИТЕ СОХРАНИТЬ ЗАПИСИ С ПОМОЩЬЮ КЛЮЧА ОТЛИЧНОГО ОТ</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 0,задайте N для &lt;Индекс (Y/N)&gt; и замените &lt;Номер ключа&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; номером соответствующего ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - ЕСЛИ ВЫ ХОТИТЕ СОХРАНИТЬ ЗАПИСИ С ПОМОЩЬЮ КЛЮЧА 0, не</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; задавайте индексный файл или номер ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Владелец&gt; именем владельца Btrieve-файла, если он</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; существует.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если логическое устройство, содержащее Ваш выходной файл, будет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; заполнено до того, как был &nbsp;сохранен весь файл, SAVE остановится,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; отобразит количество уже сохраненных записей и затем выдаст</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; следующее сообщение:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Disk volume is full. Enter new file name to continue</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;or . to quit, then press &lt;ENTER&gt;.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (Том диска заполнен. Введите имя нового файла для продолжения</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;или . для выхода, затем нажмите &lt;ENTER&gt;.)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для продолжения операции в другой выходной файл выполните одну из</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; следующих инструкций:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - ЕСЛИ ВЫ СОХРАНЯЕТ BTRIEVE-ФАЙЛ НА ДИСКЕТЕ, уберите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; полную дискету и замените ее другой отформатированной</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; дискетой.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - ЕСЛИ ВЫ СОХРАНЯЕТЕ BTRIEVE-ФАЙЛ НА ВИНЧЕСТЕРЕ, задайте</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; другое логическое устройство, имеющее свободное пространство.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; В обоих случаях введите имя файла, который Вы хотите, чтобы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve использовал для продолжения хранения записей и нажмите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; клавишу Enter. Btrieve продолжит копирование записей из Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файла в новый выходной файл.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если логическое устройство заполнено, а Вы хотите завершить</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операцию RECOVER, введите точку (.) и нажмите &lt;Enter&gt;.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е р</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующие два примера иллюстрируют, как применять SAVE для поиска</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; записей файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Первый пример используют файл внешних индексов QUICKER.IDX для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; поиска записей мз файла CUSTOMER08-14-92T и сохранения их в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; последовательном файле CUST.SAV.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BUTIL-SAVE CUSTOMER08-14-92T CUST.SAV Y QUICKREF.IDX</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующий пример ищет записи из файла CUSTOMER08-14-92T, используя</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; номер ключа 3 и сохраненяя их в последовательном файле CUST.SAV.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BUTIL-SAVE CUSTOMER08-14-92T CUST.SAV N 3</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; SINDEX</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ф о р м а т &nbsp; к о м а н д ы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BUTIL-SINDEX &lt;Btrieve-файл&gt; &lt;Файл-описание&gt; [-O &lt;Владелец&gt;]</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; SINDEX создает дополнительный индекс для существующего Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файла. Номер ключа нового индекса будет на единицу выше номера</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; предыдущего наивысшего ключа для этого файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К а к &nbsp; п р и м е н я т ь &nbsp; SINDEX</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Вы сможете запустиь SINDEX, Вы должны обеспечить</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; определение дополнительного индекса в файле-описании. См. "Файл-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; описание BUTIL" для дополнительной информации о файлах-описаниях</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; BUTIL. Смотрите примеры файла-описания в разделе "SAVE" для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; руководства по созданию файла-описания SINDEX.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для запуска SINDEX введите команду в показанном выше формате.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Btrieve-файл&gt; на имя существующего Btrieve-файла, для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; которого Вы хотите создать индекс. Вы можете задать полное имя</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; пути, если требуется.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Файл-описание&gt; именем Btrieve-файла, для которого Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; создаете индекс. Вы можете задать полное имя пути, если</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; требуется.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Владелец&gt; именем владельца Btrieve-файла, если он</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; существует.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е р</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующий пример создает дополнительный индекс для файла</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; MAILER.ADR. Имя файла-описания - SUPPIDX.DES. Имя владельца</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve-файла - "Sales".</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BUTIL-SINDEX CMAILER.ADR SUPPIDX.DES -O Sales</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; STAT</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ф о р м а т &nbsp; к о м а н д ы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BUTIL-RECOVER &lt;Имя файла&gt; [-O &lt;Владелец&gt;]</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; STAT показывает определенные характеристики Btrieve-файла и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статистику по его содержанию. &nbsp;Вы можете использовать STAT для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; определения всех параметров, заданных для нового файла командой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; CREATE. Команда STAT также обеспечивает информацию по объему</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ключей и записей файла и по имени файла-расширения, если он</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; существует.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К а к &nbsp; п р и м е н я т ь &nbsp; STAT</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для запуска STAT введите команду в показанном выше формате.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Имя файла&gt; на имя существующего Btrieve-файла, по</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; которому Вы хотите получить статистику. Вы можете задать любое</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; количество уровней директорий в имени файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Владелец&gt; именем владельца Btrieve-файла, если он</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; существует.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е р</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующий пример - получение статистики по файлу ADDRESS.BTR.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Файл не имеет имени владельца.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BUTIL-STAT ADDRESS.BTR</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Этот пример показывает, что файл ADDRESS.BTR был определен с</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; размером страницы в 1536 байт, длиной записи 147 байт и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; 2 ключами. Файл использует сжатие данных, допускает записи</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; переменной длины и имеет границу свободного пространства 10%.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Первый ключ (Ключ 0) состоит из одного сегмента, начинается в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; позиции один, длиной 30 символов, допускает дубликаты,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; немодифицируемый, имеет строковый тип ключа и не имеет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; определенного пустого значения. Ключ 0 отсортирован в убывающем</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; порядке.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Второй ключ (Ключ 1) допускает дубликаты, модифицируемый, ручной</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; и имеет пустое значение - шестнадцатиричное 20 (пробел). Он</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; состоит из двух сегментов.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Первый сегмент начинается в позиции 31, длиной в 30 байтов,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; имеет строковый тип ключа и пустое значение - &nbsp;шестнадцатиричное</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; 20 (пробел). Второй сегмент начинается в позиции 55, имеет длину</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; четыре, строковый тип ключа, убывающий и имеет пустое значение -</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; шестнадцатиричное 20 (пробел).</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; В файл было добавлено четырнадцать записей. Файл содержит 14</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; уникальных значений первого ключа и пять уникальных значений</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; второго. Файла-расширения нет.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;--------------------------------------------------------------&#172;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; File Stats for address.btr &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; Record Length = 147 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Compressed Records = Yes &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; Variable Records = Yes &nbsp; &nbsp; &nbsp; Free Space Threshold = 10% &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; Number of Keys = 2 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; Page Size = 1536 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Unused Pages = 0 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; Total Records = 14 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; Key Position Length Duplicates Modifiable &nbsp;Type &nbsp;Null &nbsp;Total&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp;0 &nbsp; &nbsp; &nbsp; 1 &nbsp; &nbsp; &nbsp;30 &nbsp; &nbsp; Yes &nbsp; &nbsp; &nbsp; &nbsp; No &nbsp; &nbsp; String&lt; __ &nbsp; &nbsp; 14 &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp;1 &nbsp; &nbsp; &nbsp;31 &nbsp; &nbsp; &nbsp;30 &nbsp; &nbsp; Yes &nbsp; &nbsp; &nbsp; &nbsp;Yes &nbsp; &nbsp; String &nbsp;20M &nbsp; &nbsp; 5 &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp;1 &nbsp; &nbsp; &nbsp;55 &nbsp; &nbsp; &nbsp; 4 &nbsp; &nbsp; Yes &nbsp; &nbsp; &nbsp; &nbsp;Yes &nbsp; &nbsp; String&lt; 20M &nbsp; &nbsp; 5 &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;L--------------------------------------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Рисунок 4.4</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Пример выхода BUTIL-STAT</p>
<p>STOP</p>
<p>Ф о р м а т к о м а н д ы</p>
<p>BUTIL-STOP</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; STOP удаляет BREQUEST и Btrieve Record Manager из памяти и,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; когда возможно, возвращает распределенную память в операционную</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; систему. После того, как Вы один раз запросили команду STOP, Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; не можете запускать прикладную программу Btrieve до тех пор, пока</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; не перезагрузите BREQUEST или Btrieve Record Manager.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К а к &nbsp; п р и м е н я т ь &nbsp; STOP</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для запуска STOP введите команду в показанном выше формате.</p>
<p>VER</p>
<p>Ф о р м а т к о м а н д ы</p>
<p>BUTIL-VER</p>
<p>О п и с а н и е</p>
<p>VER сообщает версию BREQUEST, загруженную на рабочую станцию.</p>
<p>К а к п р и м е н я т ь VER</p>
<p>Для запуска VER введите команду в показанном выше формате.</p>
<p>ИСПОЛНИТЕЛЬ ФУНКЦИЙ BTRIEVE</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Дискета Btrieve включает программу B, позволяющую Вам выполнять</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; индивидуальные Btrieve-операции интерактивно. B.EXE - прикладная</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; программа Btrieve, выполняющая Btrieve-операции, опираясь на</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; задаваемые Вами для различных подсказок значения. Каждая</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; подсказка обьяснена дальше. Программа B полезна для изучения</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; работы Btrieve, тестирования логики Вашей программы и отладки.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения B введите следующую команду после DOS-подсказки:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; B &lt;Enter&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Когда Вы выполните B, появится меню с подсказками для каждого</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; требуемого при вызове Btrieve параметра. Список кодов операций</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve приведен за подсказками.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения вызова Btrieve проинициализируйте все Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры, обычно требуемые для этой операции. Смотрите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; обсуждение Btrieve-операций записи в Главе 6 для информации о</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; требуемых параметрах. Например, для выполнения операции Open</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; выполните следующие шаги.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; 1) Задайте код операции 0.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; 2) Задайте режим "open" на подсказку "Key Number" (если надо).</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; 3) Задайте имя файла на подсказку "Key Buffer".</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; 4) Нажмите &lt;F1&gt; для выполнения Btrieve-операции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Программа B выполнит обращение к Btrieve и отобразит результат.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете продолжить выполнение Btrieve-операций. Для завершения</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; программы сперва закройте все открытые файлы, а затем нажмите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; клавишу Escape.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующий список описывает все подсказки меню утилиты B.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Подсказка &nbsp; &nbsp; &nbsp; Описание</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Function &nbsp; &nbsp; &nbsp; &nbsp;Введите код Btrieve-операции, которую Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;хотите выполнить. Список кодов операций</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;будет показан в нижней половине экрана.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;В Приложении A также имеется список кодов</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Btrieve-операций.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Key Path &nbsp; &nbsp; &nbsp; &nbsp;Задайте номер ключа для Btrieve-операции в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;поле пути ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Position Block &nbsp;Задайте файл, к которому Вы хотите получить</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;доступ, в блоке позиции. B присвоит номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;файлу на подсказку блока позиции, когда Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;успешно откроете файл в Btrieve.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Вы можете иметь до 10 открытых файлов. Когда</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Вы открываете файлы, задавайте номер файла в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;блоке позиции. Правильные значения от 0 до</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;9 включительно. Начинайте с 0 для первого</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;открываемого файла, 1 - для второго файла и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;так далее. После того, как Вы открыли файл,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;идентифицируйте его в последующих операциях,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;вводя его номер в поле блока позиции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Status &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Btrieve возвращает статус из каждой операции</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;в это поле. Полезно проинициализировать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;статус значением 99 или другим невероятным</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;кодом перед каждой операцией. Это позволит</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Вам увидеть изменение кода статуса при</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;завершении Btrieve-операции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Data Buffer &nbsp; &nbsp; Установите длину буфера данных в правильное</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Length &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;значение для операции, которую Вы хотите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;выполнить.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Data Buffer &nbsp; &nbsp; Введите данные записи в это поле для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;операций Insert или Update. Вы можете вводить</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;данные только в формате ASCII. Для операций</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Get Btrieve возвращает затребованные Вами</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;данные в буфер данных. Только ASCII данные</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;отображаются на экране.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Key Buffer &nbsp; &nbsp; &nbsp;Сохраните или имя файла или значение ключа,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;в зависимости от выполняемой операции, в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;буфере ключа. Как и в случае буфера данных,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;только ASCII данные могут быть введены или</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;отображены.</p>
<p>Следующие клавиши могут быть использованы при запуске программы B:</p>
<p>Клавиши Описание</p>
<p>&lt;Esc&gt; Завершает программу</p>
<p>&lt;F1&gt; Выполняет Btrieve-вызов</p>
<p>&lt;Home&gt; Передвигает на первую подсказку</p>
<p>&lt;End&gt; Передвигает на последнюю подсказку</p>
<p>&lt;Up&gt; Передвигает на предыдущую подсказку</p>
<p>&lt;Down&gt; Передвигает на следующую подсказку</p>
<p>&lt;Left&gt; Передвигает на символ влево</p>
<p>&lt;Right&gt; Передвигает на символ вправо</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;Обратная &nbsp; &nbsp; &nbsp; &nbsp;Передвигает на предыдущую подсказку</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; табуляция&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;Табуляция&gt; &nbsp; &nbsp; &nbsp;Передвигает на следующую подсказку</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;Ctrl-Home&gt; &nbsp; &nbsp; &nbsp;Передвигает на начало поля</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;Ctrl-End&gt; &nbsp; &nbsp; &nbsp; Передвигает на конец поля</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;Delete&gt; &nbsp; &nbsp; &nbsp; &nbsp; Удаляет символ</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;Insert&gt; &nbsp; &nbsp; &nbsp; &nbsp; Включает режим вставки</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете задавать только ASCII значения в параметрах буфера</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; данных и буфера ключа.</p>
<p>КОНСОЛЬНЫЕ КОМАНДЫ</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve обеспечивает консльными командами, позволяющими Вам</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; управлять файлами и текущим уровнем применения процесса BSERVER.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете выполнять эти команды с консоли любого файл-сервера,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; куда загружен BSERVER.VAP.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующие разделы описывают консольные команды NetWare Btrieve.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Каждое описание включает следующую информацию:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Ф о р м а т &nbsp; к о м а н д ы . Этот раздел представляет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; консольную команду в том формате6 в каком она должна быть</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; введена на файл=сервере, где загружен BSERVER.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Н а з н а ч е н и е . Этот раздел описывает применение</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; команды.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - К а к &nbsp; п р и м е н я т ь &nbsp;( к о м а н д у ) . Этот раздел</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; описывает , как запрашивать команду, и результат выполнения</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; команды.</p>
<p>B ACTIVE</p>
<p>Ф о р м а т к о м а н д ы .</p>
<p>B ACTIVE &lt;Экран&gt;</p>
<p>О п и с а н и е</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Консольная команда B ACTIVE позволяет Вам получить список всех</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve-файлов, открытых в текущее время на файл-сервере, и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; увидеть номер связи (рабочей станции) для каждого открытого файла</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; и типы захватов для каждого файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve отобразит результат команды в формате таблицы на экране.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующая информация будет показана для каждого файла:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Полное имя пути файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Номер связи сети, имеющей открытый файл.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Тип захватов для файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете использовать номер связи, возвращаемый B ACTIVE, для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; определения пользователя открытого файла. Вы можете также</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; использовать этот номер как параметр команд B RESET, BUTIL-RESET</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; или Btrieve-операции Reset для закрытия файлов и освобождения</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ресурсов некоторой станции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если другой VAP имеет открытым этот же файл, B ACTIVE отобразит</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; двухсимвольный код номера связи. Например, двухсимвольный код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; для NetWare SQL - "NS". вы не можете использовать этот</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; двухсимвольный код как вход команды B RESET. Смотрите обсуждение</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; команды B RESET на следующих страницах.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Коды для трех видов захвата:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Захват &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Транзакция &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;T</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Единичная запись &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;A</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Множество записей &nbsp; &nbsp; &nbsp; &nbsp; M</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К а к &nbsp; п р и м е н я т ь &nbsp;B ACTIVE</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для запуска B ACTIVE введите команду в показанном выше формате на</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; сервере, где загружен BSERVER.VAP.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вставьте пробел между B и ACTIVE. Вы можете вводить команду</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; символами как нижнего, так и верхнего регистров.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; B ACTIVE будет показывать сообщение на верху экрана до тех пор,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; пока не отобразит все активные файлы. Для просмотра</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; дополнительных экранов введите вновь команду B ACTIVE с номером</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &lt;Экрана&gt;, который Вы хотите посмотреть. Например, для прсмотра</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; второго экрана B ACTIVE введите следующее:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;B ACTIVE 2 &lt;Enter&gt;</p>
<p>B DOWN</p>
<p>Ф о р м а т к о м а н д ы .</p>
<p>B DOWN</p>
<p>О п и с а н и е</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Консольная команда B DOWN освобождает все ресурсы, используемые</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; BSERVER, и завершает выполнение BSERVER. Когда Вы запрашиваете</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; B DOWN, Btrieve:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Закроет все открытые на файл-сервере файлы;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Освободит все захваты Btrieve на файл-сервере;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Снимет все транзакции на файл-сервере;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Отменит выполнение BSERVER.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если Вы запускаете другой VAP, используя BSERVER для доступа к</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файлам сети, Вы должны перед запросом команды B DOWN :</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Запросить команду B ACTIVE, чтобы удостовериться, что нет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; открытых файлов для других VAP.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если другие VAP имеют открытые Btrieve-файлы на файл-сервере,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; вы должны запросить соответствующую команду для этого VAP для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; того, чтобы закрыть его файлы и прервать процесс.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Например, если Вы запускаете NetWare SQL, Вы запросите команды</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; NS RESET и NS DOWN для того6 чтобы удостовериться, что все файлы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; NetWare SQL закрыты. После того, как Вы запросите команду B DOWN</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; рабочие станции и другие VAP не смогут получить доступ к Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файлам через BSERVER до тех пор, пока вновь не будет запущен</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файл-сервер.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К а к &nbsp; п р и м е н я т ь &nbsp;B DOWN</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для запуска B DOWN введите команду в показанном выше формате на</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; сервере, где загружен BSERVER.VAP. Вставьте пробел между B и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; DOWN. Вы можете вводить команду символами как нижнего, так и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; верхнего регистров.</p>
<p>B OFF</p>
<p>Ф о р м а т к о м а н д ы .</p>
<p>B OFF</p>
<p>О п и с а н и е</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Консольная команда B OFFпрекращает обновление экрана предыдущей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; утилитой командной строки Btrieve.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете запросить B OFF после того, как B ACTIVE, B STATUS или</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; B USAGE показали необходимую Вам информацию. Если Вы не запросите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; B OFF, эти команды продолжат обновление экрана, даже если Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; запросите другую команду.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К а к &nbsp; п р и м е н я т ь &nbsp;B OFF</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для запуска B OFF введите команду в показанном выше формате на</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; сервере, где загружен BSERVER.VAP.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вставьте пробел между B и OFF. Вы можете вводить команду</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; символами как нижнего, так и верхнего регистров.</p>
<p>B RESET</p>
<p>Ф о р м а т к о м а н д ы .</p>
<p>B RESET &lt;Номер связи&gt;</p>
<p>О п и с а н и е</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Консольная команда B RESET освобождает все ресурсы, используемые</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; какой-либо станцией сети. Когда Вы запросите консольную команду</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; B RESET с номером связи станции, Btrieve:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Закроет все открытые на станции файлы;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Освободит все захваты станции;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Снимет все транзакции на станции;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Отменит выполнение BSERVER.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К а к &nbsp; п р и м е н я т ь &nbsp;B RESET</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для запуска B RESET введите команду в показанном выше формате на</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; сервере, где загружен BSERVER.VAP. Вставьте пробел между B и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; RESET. Вы можете вводить команду символами как нижнего, так и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; верхнего регистров.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Подставьте номер связи станции вместо &lt;Номер связи&gt;. Например,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; для освобождения ресурсов станции 12 Вы должны будете запросить</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; следующую команду на консоли сервера:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;B RESET 12 &lt;Enter&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Используйте звездочку (*) для всех станций сети Btrieve, а не</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; одной станции. Для освобождения всех станций сети, имеющих</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; открытые Btrieve-файлы, запросите следующую команду на консоли</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; сервера:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;B RESET * &lt;Enter&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция B RESET не допускает двухсимвольную ASCII связь ID,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; означающую VAP, как вход. Для освобождения файлов, открытых VAP,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы должны использовать соответствующую команду для VAP.</p>
<p>B STATUS</p>
<p>Ф о р м а т к о м а н д ы .</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;B STATUS</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете применять B STATUS для помощи в определении наиболее</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; эффективного уровня ресурсов, распределенных для BSERVER, для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вашей среды.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; B STATUS возвращает информацию о запросах сети, пакетных буферах</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; и проведенных сеансах для файл-сервера, с которого Вы запросили</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; команду. Команда также возвращает сколько раз обновлялся экран</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; со времени запроса команды.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К а к &nbsp; п р и м е н я т ь &nbsp;B STATUS</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для запуска B STATUS введите команду в показанном выше формате на</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; сервере, где загружен BSERVER.VAP. Вставьте пробел между B и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; STATUS. Вы можете вводить команду символами как нижнего, так и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; верхнего регистров.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Когда Вы выполните B STATUS, Btrieve покажет следующий экран:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Status for NetWare Btrieve Server VAP v5.xx</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Current, Total requests processed: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; nn &nbsp; nn</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Available, Max request buffers: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;nn &nbsp; nn</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Available, Max SPX packet buffers: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; nn &nbsp; nn</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Unprocessed SPX packet buffers: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;nn</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Current, Total SPX packets received: &nbsp; &nbsp; &nbsp; &nbsp; nn &nbsp; nn</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Current, Total SPX packets sent: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; nn &nbsp; nn</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Current, Total SPX requests processed: &nbsp; &nbsp; &nbsp; nn &nbsp; nn</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Current, Max, Peak SPX sessions: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; nn &nbsp; nn &nbsp; nn</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Nuber of display iterations: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; nn</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Значения "Current" - значения, накопленные во время запроса</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; команды B STATUS и отображаемые в первом столбце. Значения</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Total" - значения, накопленные со времени загрузки BSERVER</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; и отображаемые во втором столбце. Значения "Max" - максимальные</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; значения ресурсов, допустимых в сети текущей конфигурации,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; отображаются во втором столбце. Значения "Peak' отражают самую</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; высокую степень использования ресурсов со времени загрузки</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; BSERVER. Следующие абзацы описывают информацию, возвращаемую</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; командой B STATUS.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; "Current, Total requests processed" отражает число запросов</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; сети с помощью BSERVER с рабочих станций и других VAP таких,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; как NetWare SQL.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; "Available, Max request buffers" отражает число активных</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; процессов для VAP. Для BSERVER это значение должно быть всегда</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; равно 1.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; "Available, Max SPX packet buffers" отражает число пакетных</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; буферов NetWare, допустимых на BSERVER, и максимальное число</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; на сервере.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; "Unprocessed SPX packet buffers" отражает разницу между</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; максимальным числом допускаемых NetWare пакетных буферов на</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; сервере, и числом, допустимых для BSERVER.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; "Current, Total SPX packets received" отражает число сетевых</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; пакетов, полученных BSERVER с рабочей станции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; "Current, Total SPX packets sent" отражает число сетевых</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; пакетов, посланных BSERVER на рабочую станцию.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; "Current, Max, Peak SPX sessions" отражает число проведенных</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; сеанcов BSERVER и максимальное число. допустимое BSERVER.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; "Nuber of display iterations" отражает, сколько раз был</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; обновлен экран со времени запроса команды B STATUS.</p>
<p>B USAGE</p>
<p>Ф о р м а т к о м а н д ы .</p>
<p>B USAGE</p>
<p>О п и с а н и е</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете применять B USAGE для помощи в определении, был ли</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; BSERVER сконфигурирован самым эффективным образом для Вашей среды.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Консольная команда B USAGE возвращает информацию о следующих</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; опциях конфигурации Btrieve:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Открытые файлы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Драйверы файлов</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Захваты</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Транзакции</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; К а к &nbsp; п р и м е н я т ь &nbsp;B USAGE</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для запуска B USAGE введите команду в показанном выше формате на</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; сервере, где загружен BSERVER.VAP. Вставьте пробел между B и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; USAGE. Вы можете вводить команду символами как нижнего, так и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; верхнего регистров. Когда Вы выполняете B USAGE, Btrieve покажет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; на экране:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Usage for NetWare Btrieve Server VAP v5.xx</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Current, Max, Peak files: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;nn &nbsp; nn &nbsp; nn</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Current, Max, Peak handles: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;nn &nbsp; nn &nbsp; nn</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Current, Max, Peak locks: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;nn &nbsp; nn &nbsp; nn</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Current, Max, Peak transactions: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; nn &nbsp; nn &nbsp; nn</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Значения "Current" - значения, находящиеся в использовании в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; настоящий момент и отображаемые в первом столбце. Значения</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; "Max" - максимальные значения ресурсов, допустимых в сети текущей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; конфигурации BSERVER, отображаются во втором столбце. Значения</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; "Peak" отражают самую высокую степень использования ресурсов со</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; времени загрузки BSERVER.</p>
<p>{[logo.gif]} &nbsp;{[eXclusive Banner Network]}{[GooDoo 120]}</p>
<p>{Программы} &#8226;{Железо} &#8226; {Драйверы} &#8226; {Хостинг} &#8226;{Энциклопедия рекламы}</p>
<p>| {&lt;&lt;} | {&lt;} | {&gt;} | {&gt;&gt;}</p>
<p>------------------------------------</p>
<p>ГЛАВА 5.ИНТЕРФЕЙС ПРИКЛАДНЫХ</p>
<p>Интерфейс прикладных программ Btrieve дает Вам доступ к структурам Btrieve-файлов из ваших прикладных программ. Через эти программы Ваша прикладная программа посылает вызовы, определяющие операцию для выполнения, данные для передачи или получения, информацию о статусе и позиционировании. Эта глава описывает, как вызывать Btrieve из программм, написанных на одном из следующих языков:</p>
<p>  * IBM (или Microsoft) BASIC и BASIC-компилятор</p>
<p>  * IBM (или Microsoft) Pascal</p>
<p>  * Turbo Pascal</p>
<p>  * Microsoft COBOL</p>
<p>  * Microsoft C</p>
<p>  * Lattice c</p>
<p>  * Ассемблер</p>
<p>Для описания интерфейса, не имеющегося в данном руководстве, смотрите файл INTERFACE.DOC на программной дискете Btrieve.</p>
<p>------------------------------------</p>
<p class="note">Примечание:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;До того, как Вы сможете вызвать Btrieve из прикладной</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;программы на любом языке, Вы должны загрузить BREQUEST</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(Инициатор запросов Btrieve) в память рабочей станции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;---------------------------------------------------------</p>
<p>СВЯЗЬ BTRIVE И BASIC</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Интерфейс с Btrieve - в основном одинаков и для BASIC-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; компилятора, и для BASIC-интерпретатора. Для BASIC-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; компилятора Вы связываете интерфейс Btrieve с Вашей BASIC-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; программой после компиляции. Для BASIC-интерпретатора Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; загружаете интерфейс Btrieve как резидентную в памяти программу.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Формат обращений к Btrieve - один и тот же для обоих.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; BASIC-ИНТЕРПРЕТАТОР</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для вызова Btrieve из BASIC-интерпретатора Ваша прикладная</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; программа должна инициировать выполнение BASIC с соответствующими</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметрами и правильно загрузить Btrieve-интерфейс с BASIC.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если Вы не выполнили правильно эти два шага, прикладная программа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve не стартует надлежащим образом, если вообще стартует.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; И н т е р ф е й с &nbsp; BASIC-интерпретатора</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve-интерфейс с BASIC - подпрограмма на ассемблере,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; называющаяся BASXBTRV.EXE, которую прикладная программа на BASIC</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; должна вызывать для для связи с Btrieve Record Manager.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; В операционной &nbsp;системе MS-DOS BASIC-интерфейс - &nbsp;резидентная в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; памяти программа, которую вы должны загрузить до того, как Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; сможете запустить Вашу прикладную программу на BASIC. Каждая</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; рабочая станция должна иметь свою загруженную копию BASXBTRV.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; После того, как Вы один раз запустили Btrieve-интерфейс с BASIC,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ваша прикладная программа может использовать операторы CALL для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; выполнения Btrieve-операций.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Интерфейсная программа пишет одну запись в выходной файл,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; содержащий адрес сегмента, в который она загружена, в десятичной</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; форме. Ваша BASIC-программа читает этот файл и использует</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; хранящийся там адрес сегмента в операторе DEF SEG. После того,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; как Ваша программа выполнит DEF SEG, она может использовать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; оператор CALL (описанный далее в этой главе) для связи с Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Record Manager.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для загрузки резидентного в памяти интерфейса введите следующую</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; команду:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;Устройство&gt;BASXBTRV&lt;Имя файла.Расширение&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Устройство&gt; на имя устройства, содержащего Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файлы.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Замените &lt;Имя файла.Расширение&gt; на имя файла, который будет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; содержать адрес сегмента интерфейса. Вы должны задать имя файла</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; в виде:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;Устройство&gt;:&lt;имя файла.Расширение&gt;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете опустить &lt;Устройство&gt;, если Вы намерены использовать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; устройство, заданное по умолчанию. Как только Вы однажды</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; загрузили интерфейс, он остается в памяти до перезапуска системы.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для сетевой среды важно, является ли заданное для BASXBTRV при</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; инициализации имя файла локальным или уникальным именем файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Так как адрес сегмента, куда загружается BASXBTRV, может</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; отличаться для рабочих станций, каждая рабочая станция должна</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; иметь свой собственный файл с адресом сегмента. Например, для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; загрузки BASXBTRV и задания SEGMENT.ADR в качестве файла с</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; адресом сегмента Вы долджны запросить следующую команду:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BASXBTRV SEGMENT.ADR</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; После того, как BASIC-интерфейс загрузится в память и запишет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; свой адрес сегмента в файл, на дисплее появится следующее</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; сообщение:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Btrieve Basic interface loaded at segment xxxxx</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (Btrieve Basic интерфейс загружен в сегмент xxxxx)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ваша программа в BASIC-интерпретаторе должна включать следующие</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операторы чтения и определения адреса сегмента, чтобы обращаться</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; к Btrieve:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; 30 OPEN "SEGMENT.ADR" FOR INPUT AS #1 'Открыть файл, содержаший</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; адрес сегмента</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; 40 INPUT #1, SEG.ADDR% &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;'Получить адрес</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;сегмента интерфейса</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; 50 DEF SEG = SEG.ADDR% &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;'Установить адрес для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;обращений к Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Рисунок 4.1 иллюстрирует различные программы, загруженные в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; память, при запуске прикладной программы Btrieve, напмсанной на</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; BASIC-интерпретаторе. Первым загружен MS-DOS, за ним следует</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; резидентный в памяти BASIC-интерфейс - BASXBTRV. Btrieve загружен</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; после интерфейса. Оставшаяся память доступна Вашей прикладной</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; программе.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Начало</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;памяти&gt;&gt;&gt; &nbsp;------------------------------&#172;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; DOS 3.x &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; +-----------------------------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BASXBTRV &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;(Интерфейс BASIC-интерпрет.) &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; +-----------------------------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BREQUEST &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; +-----------------------------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Прикладная программа Btrieve &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; L------------------------------ &lt;&lt;Конец</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; памяти</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Рисунок 5.1</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Карта резидентного в памяти BASIC-интерфейса</p>
<p>З а п у с к BASIC-интерпретатора</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Обычно BASIC допускает длину записи 128 байт для любого</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; открываемого программой файла. Для доступа к Btrieve-файлу с</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; длиной логической записи большей 128 байтов Вы должны включить</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметр размера файла, задающий длину логической записи файла,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; в команду, вызывающую BASIC-интерпретатор:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BASIC &nbsp;[/S:yyy]</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; В приведенном выше примере yyy - длина логической записи самого</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; большого Btrieve-файла, к которому Ваша программа будет иметь</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; доступ. См. руководство по BASIC для дополнительной информации</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; по заданию этой опции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; BASIC-КОМПИЛЯТОР</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения программы BASIC-компилятора, обращающейся к</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve, Вы должны связать программы соответствующего Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; интерфейса с об'ектным файлом BASIC-компилятора. Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; дискеиа содержит файл, который Вы должны включить в Ваш редактор</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; BASIC-а: BASXBTRV.OBJ. Подробное описание редактора связей см. в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; руководстве по Вашей операционной системе и по BASIC.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для редактирования связей BASIC-программы, для которой об'ектный</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файл хранится в файле BASPROG, с Btrieve-интерфейсом BASICа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; BASXBTRV.OBJ Вы должны ответить на подсказку редактора связей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; для об'ектных модклей следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Object Modules [.OBJ]:basprog+basxbtrv</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;-----------------------------------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ПРИМЕЧАНИЕ:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Microsoft Quick BASIC использует файл QBIXBTRV.OBJ как</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;программу Btrieve-интерфейса и требует процедуры, отличные</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;от других версий BASIC-а, для открытия файлов и просмотра</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;буфера данных. См. файл INTRFACE.DOC на дискете "PROGRAM"</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;-----------------------------------------------------------</p>
<p>ВЫЗОВ BTRIEVE ИЗ BASIC</p>
<p>При использовании BASIC-компилятора и BASIC-интерпретатора шаги для вызова Btrieve - одни ите же. Для доступа к данным Btrieve- файла Ваша BASIC-прикладная программа должна сперва выполнить стандартный оператор BASICа OPEN NUL для размещения буфера:</p>
<p>OPEN "NUL" AS # 1</p>
<p>Когда BASIC выполнит оператор OPEN, он разместит область "Блок</p>
<p>управления файлами" (FCB). Этот блок содержит помимо других вещей область буфера, в которой хранятся данные из файла во время передачи их на диск и с диска. BASIC позволяет вам определять эту буферную область как набор непрерывных строковых переменных в операторе FIELD.</p>
<p>Например, если Вы задаете файл адресов, Ваша прикладная программа должна включать следующий оператор:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;FIELD #1, 30 AS NAM$, 30 AS STREETS$, 30 AS CITY$,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2 AS STATE$, 5 AS ZIP$</p>
<p>Этот оператор показывает, что буфер полей, предварительно распределенный для файла #1, содержит записи, в которых первые 30 символов содержат имя, следующие 30 символов - улицу и т.д.</p>
<p>BASIC ограничивает весь оператор длиной 255 символов. Если Ваша запись содержит очень много полей, Вы может быть и не сумеете полностью описать Ваши данные в одном операторе BASIC. BASIC позволяет применять столько операторов FIELDS, сколько потребуется для описания записей. Различные имена во всех операторах FIELD применимы в одно и то же время. Каждый новый оператор FIELD переопределяет буфер с позиции первого символа. Поэтому Вы должны использовать фиктивное поле как первый вход в последовательности операторов FIELD для расчета полей, которые были уже заданы.</p>
<p>Например, если записи определенные предыдущим оператором FIELD содержали номер телефона после почтового индекса, Вы можете определить поле номера телефона в следующем операторе:</p>
<p>FIELD #1, 97 AS DUMMY$, 7 AS PHONE$</p>
<p>Так как Btrieve использует буфер в FCB для передачи записей, прикладная программа должна включать оператор FIELD для того, чтобы иметь доступ к данным, возвращаемым Btrieve. Смотрите руководство по BASIc для полного описания операторов OPEN и FIELD. вы должны использовать команду LSET для сохранения значений в буфере, определенном оператором FIELD.</p>
<p>После того, как стандартный оператор BASIC OPEN откроет Btrieve- файл, Ваша прикладная программа готова посылать запросы Btrieve Record Manager. Сперва Ваша прикладная программа выполняет Btrieve-операцию Open. После этого Btrieve обрабатывает все чтения, записи и модификации файлов через btrieve-запросы. Ваша прикладная пограмма должна выполнить Btrieve-операцию Close для завершения работы.</p>
<p>Все обращения к Btrieve из BASIc должны быть в следующем формате:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; CALL BTRV (Операция, Статус, FCB, Длина буфера данных,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Буфер ключа, Номер ключа)</p>
<p>Для BASIC-интерпретатора BTRV должно быть числом 0. В BASIC- компиляторе BTRV - внешнее имя, разрешаемое редактором связей. Хотя при каждом обращении требуются все параметры, Btrieve не использует все параметры для каждой операции. В некоторых случаях Btrieve игнорирует их значение. Более детальное описание параметров смотрите в Главе 5 этого руководства. Следующие разделы описывают каждый параметр.</p>
<p>К о д о п е р а ц и и</p>
<p>Параметр операции определяет, какую Btrieve-функцию вы хотите выполнить. Задаваемая Вами переменная должна быть целого типа и может быть одним из допустимых кодов Btrieve-операции, описанных в Главе 6 этого руководства. (также смотрите Приложение A для полного списка этих кодов). ваша прикладная программа должна задавать правильный код операции при каждом обращении к Btrieve. Btrieve Record Manager никогда не изменяет код.</p>
<p>К о д с т а т у с а</p>
<p>Параметр статуса содержит значение кода, показывающее на возникновение ошибки во время Btrieve-операции. Btrieve Record Manager возвращает код статуса 0 после успешной операции. Btrieve показывает на все ошибки во время выполнения, возвращая ненулевое значение в параметр кода статуса.</p>
<p>Прикладная программа на Бейсике должна всегда посылать целую переменную как параметр статуса при Btrieve-вызове. После Btrieve- вызова прикладная программа должна всегда проверять значение переменной статуса для определения, был ли вызов успешно завершен. Смотрите в Приложении B список собщений об ошибках Btrieve и их вероятных причинах.</p>
<p>Б л о к у п р а в л е н и я ф а й л о м</p>
<p>BASIC размещает область "Блока управления файлом" (FCB) при выполнении оператора OPEN. Btrieve использует этот блок для поддержки своей позиционной информации и передачи записей данных. Поэтому Ваша прикладная программа должна передавать адрес FCB для Record Manager при каждом обращении. Ваша прикладная программа должна использовать разные адреса FCB для каждого отдельного Btrieve-файла, к которому она имеет доступ.</p>
<p>Для определения адреса FCB Ваша прикладная программа на Бейсике должна использовать оператор VARPTR. В следующем примере BASIC возвращает адрес FCB для файла, открытого как #1, в целую переменную FCB.ADDR%.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;FCB.ADDR% = VARPTR(#1)</p>
<p>Смотрите руководство по BASIC для полного описания оператора VARPTR.</p>
<p>Д л и н а б у ф е р а д а н н ы х</p>
<p>Для любой операции, использующей буфер данных, Ваша прикладная программа должна передавать длину буфера данных как целую переменную. Для файла с записями фиксированной длины этот параметр должен показывать длину записи, заданную при создании файла. Когда Вы добавляете записи или корректируете файл с записями переменной длины, этот параметр должен равняться длине записи, заданной при создании файла, плюс количество символов включенных за фиксированной частью записи. Когда Вы ищете записи переменной длины, этот параметр должен быть достаточно большим для размещения самой длинной записи файла.</p>
<p>Б у ф е р к л ю ч а</p>
<p>При каждом Btrieve-обращении Ваша BASIC- программа должна передать строковую переменную, содержащую значение ключа. Если значение ключа - целое число, Ваша прграмма должна перевести ее в строковую, используя оператор MKI$ до обращения к Btrieve. Если ключ состоит из двух или более разрывных сегментов, вы должны объединить их в одну строковую переменную и передать эту переменную как буфер ключа. В зависимости от операции ваша программа может устанавливать переменные или Record Manager может возвращать их.</p>
<p>Record Manager возвращает ошибку, если строковая переменная, передаваемая как буфер ключа, короче, чем заданная длина ключа. Если первый вызов Вашей прикладной программы не требует инициализации буфера ключа, Вы должны присвоить строковой переменной значение SPACEUNDEF, где x представляет заданную длину ключа. До тех пор, пока Ваша прикладная программа не присвоит в BASIC значение строковой переменной, она будет иметь длину 0.</p>
<p>Н о м е р к л ю ч а</p>
<p>Вы можете задавать до 24 различных ключей при создании Btrieve- файла. Когда Ваша прикладная программа будет иметь доступ к файлу, она должна сообщить Record Manager путь доступа для операции. Параметр номера ключа - целая переменная со значением от 0 до 23, где 0 -сегмент первого ключа. определенного для файла. Btrieve никогда не повторяет это значение.</p>
<p>ПРИМЕР СПИСКА ПАРАМЕТРОВ</p>
<p>BASIC-программа, показанная ниже на Рисунке 4.2, открывает Btrieve-файл и ищет запись данных, соответствующую первому</p>
<p>значению ключа 0 - полю имени.</p>
<p>'Строки с 5 по 20 применимы только для BASIC-интерпретатора. 'Не включайте их в BASIC-компилятор 5 BTRV = 0</p>
<p>10 OPEN "SEGMENT.ADR" FOR INPUT AS #1 15 INPUT #1, SEG.ADDR%</p>
<p>20 DEF SEG = SEG.ADDR%</p>
<p>30 OPEN "NUL" AS #2</p>
<p>40 FIELD #2, 30 AS NAME$, 30 AS STREETS$,</p>
<p>30 AS CITY$, 2 AS STATE$, 6 AS ZIP$ 50 OP% = 0 : STATUS% = 0</p>
<p>70 FCB.ADDR% = VARPTR(#2) : BUF.LEN% = 98 80 KEY.BUF$ = "ADDRESS.BTR</p>
<p>90 KEY.NUM% = 0</p>
<p>100 CALL BTRV(OP%,STATUS%,FCB.ADDR%,BUF.LEN%,KEY.BUF$,KEY.NUM%) 110 IF STATUS% &lt;&gt; O THEN</p>
<p>PRINT "Ошибка открытия файла. Статус =", STATUS% : END 120 OP% = 12</p>
<p>125 KEY.BUF$ = SPACEUNDEF</p>
<p>130 CALL BTRV(OP%,STATUS%,FCB.ADDR%,BUF.LEN%,KEY.BUF$,KEY.NUM%) 140 IF STATUS% &lt;&gt; O THEN</p>
<p>PRINT "Ошибка открытия файла. Статус =", STATUS% : END 150 PRINT "Первая запись файла",NAM$,STREET$,CITY$,STATE$,ZIP$</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Рисунок 5.2</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Btrieve-вызов из BASIC</p>
<p>СВЯЗЬ BTRIVE И PASCAL</p>
<p>Для доступа к Btrieve-файлам прикладная программа на Паскале должна задать BTRV как целую функцию. Когда Ваша прикладная программа вызывает эту функцию, она выполняет различные типы доступа к файлу в зависимости от заданных параметров. Интерфейс Паскаля взаимодействует с Btrieve Record Manager. Вы должны загрузить Record Manager, резидентную в памяти программу на ассемблере, до запуска Вашей прикладной программы.</p>
<p>Объявите Btrieve-функцию как внешнюю для IBM (или Microsoft) Pascal. Btrieve обеспечивает маленькой программой на ассемблере которую вы можете связать с Вашей прикладной программой на Паскале как внешнюю функцию. Для Turbo Pascal Btrieve обеспечивает исходный код интерфейса таким образом, что вы можете включить его с Вашей программой на Паскале для компиляции.</p>
<p>Программная дискета Btrieve содержит файл, требуемый для включения в Ваш исходный файл на Паскале. Для IBM Pascal файл содержит объявление внешней функции для BTRV. Для Turbo Pascal файл содержит код всего Btrieve-интерфейса.</p>
<p>Ваша прикладная программа получает доступ ко всем Btrieve-файлам, вызывая функцию BTRV. Это -целая функция, возвращающая статус операции. Если вы используете IBM (или Microsoft) Pascal, используйте метакоманду $INCLUDE для подключения файла BEXTERN114S. пример ниже показывает как определена внешняя функция BTRV:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; function BTRV ( &nbsp; &nbsp; OP &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : integer;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;vars POS_BLOCK &nbsp; &nbsp;: string;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;vars DATA_BUFFER &nbsp;: string;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;vars DATA_LEN &nbsp; &nbsp; : integer;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;vars KEY_BUFFER &nbsp; : string;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;KEY_NUMBER &nbsp; : integer ) :integer; extern;</p>
<p>Если вы используете Turbo Pascal, применяйте команду $I для подключения файла TURXBTRV114S. Btrieve-функция определяется следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; function BTRV ( &nbsp; &nbsp; OP &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : integer;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;var &nbsp;POS_BLOCK,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;var &nbsp;DATA_BUFFER;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;var &nbsp;DATA_LEN &nbsp; &nbsp; : integer;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;var &nbsp;KEY_BUFFER;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;KEY_NUMBER &nbsp; : integer ) :integer;</p>
<p>КОМПОНОВКА ПРИКЛАДНОЙ PASCAL-ПРОГРАММЫ С BTRIEVE</p>
<p>Если вы используете IBM (или Microsoft) Pascal, вы должны подключить файл PASXBTRV.OBJ к редактору связей Паскаля. Для компановки объектного файла Паскаля (PASPROG) с интерфейсом IBM Pascal Вы должны ответить на подсказку редактора связей следующим образом:</p>
<p>Object Modules[.OBJ]:pasprog+pasxbtrv</p>
<p>Если Вы используете Turbo Pascal подключайте исходный файл интерфейса TURXBTRV114S к Вашей программе при компиляции.</p>
<p>ВЫЗОВ BTRIEVE ИЗ PASCAL</p>
<p>Ваша Pascal-прикладная программа никогда не должна выполнять стандартный ввод/вывод Паскаля для Btrieve-файлов. Ваша прикладная программа должна выполнять весь ввод/вывод Btrieve- файла с помощью Btrieve-функций. Первый Btrieve-вызов, который должна выполнить Ваша прикладная программа, -операция Open. Вслед за этим Вы можете читать, писать и модифицировать файлы через обращения к Btrieve. До завершения Вашей прикладной программы необходимо выполнить Btrieve-операцию Close.</p>
<p>Все обращения к Btrieve должны быть выполнены через BTRV- функцию. Результат функции всегда целое значение, соответствующее одному из кодов статуса, перечисленных в Приложении B. После вызова Btrieve ваша прикладная программа должна всегда проверять значение переменной статуса. Статус 0 показывает на успешное выполнение операции. Ваша прикладная программа должна быть способна распознавать и принимать решения по ненулевым статусам.</p>
<p>Хотя при каждом обращении требуются все параметры, Btrieve не использует все параметры для каждой операции. В некоторых случаях Btrieve игнорирует их значение. Более детальное описание параметров смотрите в Главе 5 этого руководства. Следующие разделы описывают каждый параметр.</p>
<p>К о д о п е р а ц и и</p>
<p>Параметр операции определяет, какой тип Btrieve-функции Вы хотите выполнить. Ваша прикладная программа должна быть способна задавать правильный код операции при каждом обращении к Btrieve. Record Manager никогда не изменяет код операции. Задаваемая Вами переменная должна быть целого типа и может быть одним из допустимых кодов операций, описанных в Главе 6. Приложение A содержит полный список этих кодов</p>
<p>Б л о к п о з и ц и и</p>
<p>Ваша прикладная программа должна размещать отдельный блок позиции для каждого открываемого Btrieve-файла. Btrieve инициализирует блок позиции при выполнении операции Open и ссылается и корректирует данные в блоке позиции при всех операциях над файлами. Поэтому Ваша прикладная программа должна посылать один и тот же блок позиции при всех последовательных Btrieve-операциях над файлами. Когда Ваша прикладная программа имеет более одного открытого файла одновременно, btrieve использует блок позиции для определения, на какой файл ссылаются при каком-либо вызове. Вдобавок, Ваша прикладная программа никогда не должна изменять значения в блоке позиции.</p>
<p>IBM Pascal прикладная программа должна размещать 128-байтовую строку для блока позиции. Если вы используете Turbo Pascal, Вы должны размещать параметр блоак позиции как 128-байтовый символьный массив.</p>
<p>Б у ф е р д а н н ы х</p>
<p>Буфер данных содержит записи, передавемые Вашей прикладной программой в Btrieve и из него. Btrieve ожидает строковый тип для IBM Pascal. Для Turbo Pascal вы можете использовать любой тип данных.</p>
<p>Вы можете захотеть задать структуру записи Паскаля для описания</p>
<p>данных, хранимых в файле. Для передачи переменной типа записи в IBM Pascal применяйте опцию case для задания переменной строкового типа структуры. Для Turbo Pascal Вы можете посылать саму запись.</p>
<p>Когда Вы вычисляете длину переменной строки, примите в расчет, что элементы четной длины в записи могут потребовать дополнительный байт для хранения, независимо от того, была ли упакована запись или нет. Это также важно рассматривать при определении длины записи для утилиты CREATE. Смотрите руководство по Паскалю для дополнительной информации о типах записи.</p>
<p>Д л и н а б у ф е р а д а н н ы х</p>
<p>Для любой операции, использующей буфер данных, Ваша прикладная программа должна передавать длину буфера данных как целую переменную. Для файла с записями фиксированной длины этот параметр должен показывать длину записи, заданную при создании файла.</p>
<p>Когда Вы добавляете записи или корректируете файл с записями переменной длины, этот параметр должен равняться длине записи, заданной при создании файла, плюс количество символов включенных за фиксированной частью записи. Когда Вы ищете записи переменной длины, этот параметр должен быть достаточно большим для размещения самой длинной записи файла.</p>
<p>Б у ф е р к л ю ч а</p>
<p>Ваша прикладная программа должна передать строковую переменную для IBM Pascal или переменнуб любого типа для Turbo Pascal, содержащую значение ключа при каждом обращении к Btrueve. В зависимости от операции Ваша прикладная программа может устанавливать эту переменную или Record Manager может возвращать ее.</p>
<p>Ддя IBM Pascal, если значение ключа - целое число, Вы должны определить ее как структуру записи с двумя переменными. Одна переменная определяет ключ как целое. другая определяет его как двухсимвольную строку. Вы должны использовать строковую переменную для обращений к Btrieve.</p>
<p>Для Turbo Pascal Вы можете передавть сам буфер ключа, независимо от типа.</p>
<p>Если ключ состоит из двух или более сегментов, используйте структуру записи для определения полей ключа. Затем используйте переменную для передачи буфера ключа в Btrieve.</p>
<p>Н о м е р к л ю ч а</p>
<p>Вы можете задавать до 24 различных ключей при создании Btrieve-</p>
<p>файла. Поэтому Ваша прикладная программа должна сообщить Record Manager путь доступа для данной операции. Параметр номера ключа - целая переменная со значением от 0 до 23, где 0 -сегмент первого ключа. определенного для файла. Record Manager никогда не повторяет этот параметр.</p>
<p>ПРИМЕР СПИСКА ПАРАМЕТРОВ</p>
<p>IBM (или Microsoft) Pascal-программа, показанная ниже на Рисунке 5.3, открывает Btrieve-файл и ищет запись данных, соответствующую первому значению ключа 0 - полю имени.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; const</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; B_GET_FST = 12;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; B_OPEN = 0;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; type</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ADDRESS_REc = record</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;case integer of</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 1: (NAME &nbsp; &nbsp; &nbsp;: string(30);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;STREET &nbsp; &nbsp; : string(30);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;CITY &nbsp; &nbsp; &nbsp; : string(30);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;STATE &nbsp; &nbsp; &nbsp;: string(2);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ZIP &nbsp; &nbsp; &nbsp; &nbsp;: string(5));</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2: (ENTIRE &nbsp; &nbsp;: string(98));</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;end;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; var</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; DATA_BUF &nbsp; &nbsp; &nbsp; &nbsp; : ADDRESS.REC;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; DB_LEN &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : integer;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; FILE_NAME &nbsp; &nbsp; &nbsp; &nbsp;: string(14);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; KEY_BUF &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: string(30);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; POS_BLOCK &nbsp; &nbsp; &nbsp; &nbsp;: string(128);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; STATUS &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : integer;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; begin</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; FILE_NAME :='B:ADDRESS.BTR';</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; STATUS :=BTRV(B_OPEN,POS_BLOCK,DATA_BUF.ENTIRE,DB_LEN,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; FILE_NAME,0);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; if STATUS &lt;&gt; O then</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; begin</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;writelen(OUTPUT,'Ошибка открытия файла. Статус =',</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; STATUS); return;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;end;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; DB_LEN :=sizeof(ADDRESS_REC);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; STATUS :=BTRV(B_GET_FST,POS_BLOCK,DATA_BUF.ENTIRE,DB_LEN,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; KEY_BUF,0);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; if STATUS &lt;&gt; O then</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; begin</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;writelen(OUTPUT,'Ошибка открытия файла. Статус =',</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; STATUS);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; else</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;writelen(OUTPUT,'Первая запись файла',DATA_BUF.ENTIRE);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; end.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Рисунок 5.3</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Обращение к Btrieve из IBM PAscal</p>
<p>Рисунок 5.4 показывает ту же самую программу, написанную на Turbo Pascal. Это единственный пример для Turbo Pascal в этом руководстве. Все другие примеры приведены для IBM (Microsoft) Pascal.</p>
<p>На рисунке 5.4 прикладная программа использует символьные массивы вместо строк для полей в буфере данных и буфере ключа, потому что Turbo Pascal хранит байт двоичной длины в первой позиции строкового поля при инициализации поля. Если Вы пытаетесь использовать такое значение как ключ Btrieve-файла без определения его как l-строки, результат будет непредсказуем. Когда Btrieve сравнивает значения ключей при случайном или последовательном поиске, он сравнивае их байт за байтом от абсолютного базиса. Байт длины рассматривается как часть значения вместо индикатора длины, пока ключ не будет определен как l-строка.</p>
<p>Хотя пример на Рисунке 5.4 использует переменные записи для параметров блока позиции, буфера данных и буфера ключа, Btrieve не требует этого от Вас. Этот пример просто иллюстрирует один из способов написания программы.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; const</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; B_GET_FST = 12;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; B_OPEN = 0;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; type</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ADDRESS_REC = record</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;{Structure of address file entry}</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;case integer of</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 1: (NAME &nbsp; &nbsp; &nbsp;: array[1..30] of char;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;STREET &nbsp; &nbsp; : array[1..30] of char;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;CITY &nbsp; &nbsp; &nbsp; : array[1..30] of char;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;STATE &nbsp; &nbsp; &nbsp;: array[1..2] of char;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ZIP &nbsp; &nbsp; &nbsp; &nbsp;: array[1..5] of char;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2: (START &nbsp; &nbsp; : integer);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;end;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; FILE_NAME = record</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; case integer of</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1:(VALUE &nbsp; : array[1..14] of char);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2:(START &nbsp; : integer);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; end;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; KEY_BUF = record</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; case integer of</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1:(VALUE &nbsp; : array[1..30] of char);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2:(START &nbsp; : integer);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; end;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; var</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; DATA_BUF &nbsp; &nbsp; &nbsp; &nbsp; : ADDRESS.REC;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; DB_LEN &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : integer;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; FNAME &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: FILE_NAME;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; KBUF &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : KEY_BUF;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; POS &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: record</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; case integer of</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1:(START &nbsp; : integer);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2:(BLK &nbsp; &nbsp; :array[1..128] of byte);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; end;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; STATUS &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : integer;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; I &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: integer;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; {$I TURXBTRV119S}</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; begin</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; FNAME.VALUE :='B:ADDRESS.BTR';</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; STATUS :=BTRV(B_OPEN,POS_START,DATA_BUF.START,DB_LEN,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; FNAME.START,0);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; if STATUS &lt;&gt; O then</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;writelen(OUTPUT,'Ошибка открытия файла. Статус =',</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; STATUS)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; else</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;begin</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; DB_LEN :=sizeof(ADDRESS_REC);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; STATUS :=BTRV(B_GET_FST,POS.START,DATA_BUF.START,DB_LEN,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; KBUF.STAT,0);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; if STATUS &lt;&gt; O then</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;writelen(OUTPUT,'Ошибка открытия файла. Статус =',</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; STATUS)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; else</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;writelen(OUTPUT,'Первая запись файла',DATA_BUF.NAME,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; DATA_BUF.STREET,DATA_BUF.CITY,DATA_BUF.STATE,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;DATA_BUF.ZIP);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; end;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; end.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Рисунок 5.4</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Обращение к Btrieve из Turbo Pascal</p>
<p>СВЯЗЬ BTRIVE И C</p>
<p>Btrieve-дискета содержит интерфейс для Microsoft и Latice C и для других компиляторов C. Формат обращений к Btrieve идентичен для всех. Связь с другими компиляторами C смотрите в Приложении F которое описывает, как связать Btrieve из ассемблера.</p>
<p>Ваша Btrieve программная дискета содержит исходный код для каждого из этих интерфейсов. Весь C-интерфейс написан на C.</p>
<p>Для доступа к Btrieve-файлу Ваша прикладная программа должна вызвать целую функцию BTRV. Btrieve обеспечивает небольшой интерфейсной программой, связывающей Btrieve Record Manager с Вашей прикладной программой на C. Вы должны загрузить Record Manager до того, как стартуете Вашу прикладную программу.</p>
<p>КОМПОНОВКА ПРИКЛАДНОЙ C-ПРОГРАММЫ С BTRIEVE</p>
<p>После успешной компиляции программы на C скомпануйте ее с C-интерфейсом. Метод, применяемый при компоновке с C-интерфейсом, немного зависит от применяемого Вами компилятора C. Полное описание компоновки смотрите в руководствах по операционной системе и по компилятора.</p>
<p>Если вы используете компилятор Microsoft C, Вы должны скомпилировать интерфейсный файл MSCXBTRV.C с помощью Вашего компилятора. Если Вы компилируете большую модель, Вы должны отредактировать исходный файл интерфейса и сделать изменения, описанные в этом документе. Компануйте Вашу прикладную программу как показано ниже в примере:</p>
<p>Object Modules[.OBJ]:c+cprog+mscxbtrv</p>
<p>ВЫЗОВ BTRIEVE ИЗ C</p>
<p>Ваша прикладная программа никогда не должна выполнять стандартный ввод/вывод C для Btrieve-файлов. Ваша прикладная программа должна выполнять весь ввод/вывод Btrieve- файла с помощью Btrieve-функций. После выполнения операции Open Ваша программа можете читать, писать и модифицировать файлы через обращения к Btrieve. До завершения Вашей прикладной программы необходимо выполнить Btrieve-операцию Close.</p>
<p>Ваша прикладная программа выполняет обращения к Btrieve через целую функцию BTRV. Результат функции всегда целое значение, соответствующее одному из кодов статуса, перечисленных в</p>
<p>Приложении B. После вызова Btrieve Ваша прикладная программа должна всегда проверять значение переменной статуса. Статус 0 показывает на успешное выполнение операции. Ваша прикладная программа должна быть способна распознавать и принимать решения по ненулевым статусам.</p>
<p>Функция BTRV ожидает параметры следующего типа:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; int BTRV(OP,POS_BLK,DATA_BUF,BUF_LEN,KEY_BUF,KEY_NUM)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;int &nbsp; OP; &nbsp; &nbsp; &nbsp; &nbsp; /* код операции */</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;char &nbsp;POS_BLK[]; &nbsp;/* блок позиции */</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;char &nbsp;DATA_BUF[]; /* буфер данных */</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;int &nbsp; *BUF_LEN; &nbsp; /* длина буфера данных */</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;char &nbsp;KEY_BUF[]; &nbsp;/* буфер ключа */</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;int &nbsp; KEY_NUM; &nbsp; &nbsp;/* номер ключа */</p>
<p>Хотя при каждом обращении требуются все параметры, Btrieve не использует все параметры для каждой операции. В некоторых случаях Btrieve игнорирует их значение. Более детальное описание параметров смотрите в Главе 5 этого руководства. Следующие разделы описывают каждый параметр.</p>
<p>К о д о п е р а ц и и</p>
<p>Параметр операции определяет, какой тип Btrieve-функции Вы хотите выполнить. Могут быть операции чтения, записи, удаления или корректировки. Ваша прикладная программа должна быть способна задавать правильный код операции при каждом обращении к Btrieve. Record Manager никогда не изменяет код операции. Задаваемая Вами переменная должна быть целого типа и может быть одним из допустимых кодов операций, описанных в Главе 6. Приложение A содержит полный список этих кодов.</p>
<p>Б л о к п о з и ц и и</p>
<p>Прикладная программа на C размещает 128-байтовый массив, который Btrieve использует для хранения структур ввода/вывода файла и позиционной информации, описанной в Главе 2. Btrieve инициализирует этот массив, когда Ваша прикладная программа выполняет операцию Open. Btrieve ссылается на данные этого массива и корректирует их при всех операциях над файлом. Ваша прикладная программа никогда не должна изменять значения, хранящиеся в этом массиве.</p>
<p>Когда Ваша прикладная программа имеет более одного открытого файла одновременно, Btrieve использует блок позиции для определения, на какой файл ссылаются при каком-либо вызове. Ваша прикладная программа должна размещать отдельный блок позиции для каждого открываемого Btrieve-файла.</p>
<p>Б у ф е р д а н н ы х</p>
<p>Параметр буфера данных - адрес массива или переменной типа структуры, содержащей записи, передавемые Вашей прикладной программой в Btrieve-файл и из него. Удостовертесь, что Вы размещаете достаточно большой буфер данных для размещения самой длинной записи в файле. если буфер слишком мал, Btrieve-запросы могут повредить данные, следующие за буфером данных.</p>
<p>Д л и н а б у ф е р а д а н н ы х</p>
<p>Для любой операции, использующей буфер данных, Ваша прикладная программа должна передавать адрес целой переменной, содержащей длину буфера данных. Для файла с записями фиксированной длины этот параметр должен показывать длину записи, заданную при создании файла.</p>
<p>Когда Вы добавляете записи или корректируете файл с записями переменной длины, этот параметр должен равняться длине записи, заданной при создании файла, плюс количество символов включенных за фиксированной частью записи. Когда Вы ищете записи переменной длины, этот параметр должен быть достаточно большим для размещения самой длинной записи файла.</p>
<p>Б у ф е р к л ю ч а</p>
<p>Ваша прикладная программа должна передать адрес переменной, содержащей значение ключа при каждом обращении к Btrieve. Если вы определяете ключ как двоичное, когда Вы впервые создаете файл, вы должны определить переменную типа int, long или unsigned. Если Вы определили ключ как строку, Вы должны определить переменную буфера ключа как структуру или символьный массив. Если ключ состоит из двух или более сегментов, используйте переменную структуры, состоящую из полей сегментов в правильном порядке. В зависимости от операции Ваша прикладная программа может устанавливать эту переменную или Btrieve Record Manager может возвращать ее.</p>
<p>Btrieve не может определить длину буфера ключа при вызове из программы на C. Поэтому вы должны удостовериться, что буфер - по крайней мере не меньше длины ключа, заданной Вами при создании файла. Иначе Btrieve-запросы могут разрушить данные, хранящиеся в памяти за буфером ключа.</p>
<p>Н о м е р к л ю ч а</p>
<p>Вы можете задавать до 24 различных ключей при создании Btrieve- файла. Поэтому Ваша прикладная программа должна сообщить Record Manager путь доступа для данной операции. Параметр номера ключа - целая переменная со значением от 0 до 23, где 0 -сегмент первого ключа. определенного для файла. Record Manager никогда не</p>
<p>повторяет этот параметр.</p>
<p>ПРИМЕР СПИСКА ПАРАМЕТРОВ</p>
<p>C-программа на Рисунке 5.6 открывает Btrieve-файл и ищет запись данных, соответствующую первому значению ключа 0 - полю имени.</p>
<p>#define B_OPEN 0</p>
<p>#define B_FIRST 12</p>
<p>main(){</p>
<p>  &nbsp; &nbsp; &nbsp; struct ADDR_REC &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;/* Структура записи адреса в файле*/</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; {</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;char &nbsp;NAME[30];</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;char &nbsp;STREET[30];</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;char &nbsp;CITY[30];</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;char &nbsp;STATE[2];</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;char &nbsp;ZIP[5];</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;};</p>
<p>struct ADDR_REC ADDR_BUF;</p>
<p>int DB_LEN;</p>
<p>char KEY_BUF[30];</p>
<p>char POS_BLK[128];</p>
<p>int STATUS;</p>
<p>STATUS =BTRV(B_OPEN,POS_BLK,&amp;ADDR_BUF,&amp;DB_LEN,"ADDRESS.BTR",0); if (STATUS != O)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; {</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;print("Ошибка открытия файла. Статус = %d", STATUS);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;exit(0);</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; }</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;DB_LEN = sizeof(ADDR_BUF);</p>
<p>STATUS = BTRV(B_FIRST,POS_BLK,&amp;ADDR_BUF,&amp;DB_LEN,KEY_BUF,0); if (STATUS != O)</p>
<p>print("Ошибка открытия файла. Статус = %d", STATUS); else</p>
<p>print("Первая запись файла: %.97s",&amp;ADDR_BUF); };</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Рисунок 5.6</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Обращение к Btrieve из C</p>
<p>СВЯЗЬ BTRIVE И АCСЕМБЛЕРА</p>
<p>Если Вы используете ассемблер или язык программирования, для которого нет интерфейса на Btrieve-дискете, Вы можете создать интерфейс, применяя ассемблер. Программа связи Btrieve с ассемблером требует выполнения трех основных шагов:</p>
<p>  * Хранения Btrieve-параметров в памяти в формате, ожидаемом Btrieve Record Manager</p>
<p>  * Проверки, что Record Manager был загружен в память</p>
<p>  * Вызова Record Manager с помощью выполнения прерывания, передающего управление Btrieve</p>
<p>ХРАНЕНИЕ ПАРАМЕТРОВ</p>
<p>Предыдущие разделы этой главы описывали только семь Btrieve- параметров: статус, код операции, блок позиции, буфер данных, длина буфера данных, буфер ключа и номер ключа. (BASIC-интерфейс объединяет блок позиции и буфер данных в один параметр - FCB. Паскаль и C интерфейс возвращают код статуса как значение функции.)</p>
<p>В действительности Record Manager ожидает десять параметров. Программы интерфейса с языками, обеспечиваемые Btrieve, извлекают три параметра до передачи управления Record Manager. Для создания на ассемблере своего собственного интерфейса с Btrieve Вы должны проинициализировать все десять параметров. Следующий рисунок показывает все десять параметров Btrieve и их формат.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;--------------T----------T-----------------------------&#172;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; N параметра &#166; Смещение &#166; &nbsp; &nbsp; &nbsp; &nbsp;Содержание &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+-------------+----------+-----------------------------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;1 &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; 0 &nbsp; &nbsp;&#166; &nbsp;смещение буфера данных &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+-------------+----------+-----------------------------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp;сегмент &nbsp;буфера данных &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+-------------+----------+-----------------------------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;2 &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; 4 &nbsp; &nbsp;&#166; &nbsp;длина &nbsp; &nbsp;буфера данных &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+-------------+----------+-----------------------------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;3 &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; 6 &nbsp; &nbsp;&#166; &nbsp;смещение позиц.информации &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+-------------+----------+-----------------------------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp;сегмент &nbsp;позиц.информации &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+-------------+----------+-----------------------------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;4 &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; 10 &nbsp; &#166; &nbsp;смещение FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+-------------+----------+-----------------------------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp;сегмент &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+-------------+----------+-----------------------------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;5 &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; 14 &nbsp; &#166; &nbsp;код операции &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+-------------+----------+-----------------------------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;6 &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; 16 &nbsp; &#166; &nbsp;смещение буфера ключа &nbsp; &nbsp; &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+-------------+----------+-----------------------------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp;сегмент &nbsp;буфера ключа &nbsp; &nbsp; &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+-------------+----------+-----------------------------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; 7,8 &nbsp; &nbsp; &#166; &nbsp; &nbsp; 20 &nbsp; &#166; &nbsp;длина ключа &nbsp;| номер ключа &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+-------------+----------+-----------------------------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;9 &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; 22 &nbsp; &#166; &nbsp;смещение статуса &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+-------------+----------+-----------------------------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp;сегмент &nbsp;статуса &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+-------------+----------+-----------------------------+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;10 &nbsp; &nbsp; &#166; &nbsp; &nbsp; 26 &nbsp; &#166; &nbsp;ID интерфейса &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;L-------------+----------+------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Рисунок 5.7</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Структура Btrieve-параметров</p>
<p>До того, как Вы сможете обратиться к Btrieve, Вы должны проинициализировать область данных, содержащую все десять параметров, перечисленных на Рисунке 5.1. Храните смещение этой области данных в регистре DX. Btrieve ожидает адрес блока параметров в DS:DX, когда он получает управление.</p>
<p>ОПИСАНИЕ ПАРАМЕТРОВ</p>
<p>Следующие разделы описывают исе десять параметров, ожидаемых Btrieve при использовании программы интерфейса на ассемблере.</p>
<p>Б у ф е р д а н н ы х</p>
<p>Передавайте буфер данных как двойное слово, содержащее адрес сегмента и смещение буфера данных прикладной программы. Буфер данных - область, используемая для передачи записей между прикладной программой и Record Manager.</p>
<p>Д л и н а б у ф е р а д а н н ы х</p>
<p>Передавайте длину буфера данных как слово, содержащее длину буфера данных. Прикладная программа передает интерфейсу адрес целой переменной, содержащей длину буфера данных. Интерфейс должен скопировать значение длины буфера данных в блок параметра передаваемого Btrieve. После возврата из Btrieve-прерывания интерфейс должен скопировать значение длины буфера данных из блока параметра обратно по адресу, заданному прикладной программой.</p>
<p>П о з и ц и о н н а я и н ф о р м а ц и я</p>
<p>Передавайте позиционную информацию как двойное слово, содержащее адрес сегмента и смещение 90-байтовой области данных, используемой Btrieve для хранения позиционной информации файла.</p>
<p>Это один из параметров, извлекаемых Btrieve-интерфейсом прикладной программы. В BASIC эта область получается из FCB. В других языках для этой цели используется часть параметра блока позиции. Вы должны обеспечить Record Manager адресом 90-байтовой области для использования при вызове Btrieve из ассемблера. Та же самая область данных должна быть передана в Btrieve при всех обращениях к тому же файлу.</p>
<p>FCB</p>
<p>Передавайте FCB как двойное слово, содержащее адрес сегмента и смещение 38-байтовой области данных, используемой Btrieve для хранения DOS FCB. Это один из параметров, извлекаемых Btrieve- интерфейсом прикладной программы. В BASIC эта область получается из BASIC FCB. В других языках для этой цели используется часть параметра блока позиции. Вы должны обеспечить Record Manager адресом 38-байтовой области для использования при вызове Btrieve из ассемблера. Тот же самый FCB должен быть передан в Btrieve при всех обращениях к тому же файлу.</p>
<p>К о д о п е р а ц и и</p>
<p>Передавайте код операции как слово, содержащее дкод операции Btrieve. Это должен быть один из кодов Btrieve-операции, перечисленных в Приложении A.</p>
<p>Б у ф е р к л ю ч а</p>
<p>Передавайте буфер ключа как двойное слово, содержащее адрес сегмента и смещение буфера ключа прикладной программы.</p>
<p>Д л и н а к л ю ч а</p>
<p>Передавайте длину ключа как байт, содержащий длину буфера ключа. Это один из параметров, извлекаемых Btrieve-интерфейсом прикладной программы, который Вы должны обеспечить при вызове Btrieve из ассемблера.</p>
<p>Интерфейсы Btrieve с COBOL и C не могут определить длину буфера ключа, так как он не передается с типом данных при компиляции. В этих случаях Btrieve передает максимальную допустимую длину ключа. Record Manager никогда не будет записывать буфер ключа за заданную длину ключа. Record Manager возвратит ошибку, если этот параметр короче, чем заданная длина ключа.</p>
<p>Н о м е р к л ю ч а</p>
<p>Передавайте номер ключа как байт, содержащий номер ключа, с помощью которого можно получить доступ к файлу.</p>
<p>К о д с т а т у с а</p>
<p>Передавайте код статуса как двойное слово, содержащее адрес сегмента и смещение параметра статуса. Это адрес, по которому Btrieve будет хранить код статуса после выполнения операции.</p>
<p>ID и н т е р ф е й с а</p>
<p>Передавайте ID интерфейса как слово, проинициализированное значением 06176H. Если Вы установите идентификатор в любое другое значение, Btrieve не позволит иметь доступ к записям переменной длины. Эта проверка позволяет Btrieve определять, был ли он вызван из прикладных программ, скомпанованных с предыдущими версиями интерфейса, которые не понимают записи переменной длины7</p>
<p>ПРОВЕРКА ЗАГРУЗКИ RECORD MANAGER</p>
<p>Как только параметры проинициализированы, проверьте, что Record Manager загружен, до обращения к нему. Когда Record Manager загружен, он хранит точку входа в векторе прерываний 07BH. Удостоверьтесь, что слово вектора прерывания 07BH проинициализировано значением 033H, чтобы интерфейс мог определить, загружен ли Record Manager.</p>
<p>ВЫЗОВ RECORD MANAGER</p>
<p>После того, как Вы сохранили адрес Btrieve-параметров в DX и проверили, что Record Manager загружен, Вы готовы к вызову Btrieve. выполните прерывание 07BH и Record Manager выполнит Ваш запрос. Когда операция выполнена, Record Manager вернет управление в Вашу программу по инструкции, следующей за прерыванием. Следующий пример показывает программу, которая проверяет загружен ли Record Manager изатем выполняет прерывание.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; BTR_ERR &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; EQU 20</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; BTR_VECTOR &nbsp; &nbsp; &nbsp; &nbsp;EQU 07BH*4</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; PUSH DS</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; SUB &nbsp;BX,BX &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ;Очистка BX</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; MOV &nbsp;DS,BX &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ;DS=&gt;абсолютный 0</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; CMP &nbsp;WORD PTR BTR_VECTOR[BX],033H &nbsp;;Был ли Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; инициализирован</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; POP &nbsp;DS</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; JE &nbsp; DO_INT &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;;Да - переход на</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; выполнение прерывания</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; MOV &nbsp;STAT,BTR_ERR &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;;Нет - установка</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; статуса 20</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; JMP &nbsp;OUT &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ;и возврат к вызывающей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; программе</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; DO_INT:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; INT &nbsp;07BH &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;;Вызов Record Manager</p>
<p>ИНТЕРФЕЙС OS/2</p>
<p>NetWare Btrieve включает два интерфейса для C-компилятора OS/2 (C2XBTRV.C и C2FXBTRV.C), которые Вы можете подключать к прикладным прогаммам, запускаемым на рабочих станциях OS/2. Интерфейс C2XBTRV.C - для применения с прикладными программами в защищенном режиме. Интерфейс C2FXBTRV.C - для применения с программами OS/2 FAPI.</p>
<p>Если Вы используете язык, который может вызывать программу на ассемблере, Вы можете написать на ассемблере интерфейс с Btrieve, используя как руководство любой исходный текст интерфейса. Следующий раздел содержит руководство по применению интерфейса C и создания своего собственного интерфейса на ассемблере.</p>
<p>ЯЗЫК C</p>
<p>Если Вы применяете C-компилятор, поставляемые с OS/2, Вы имеете две опции:</p>
<p>  * Вы можете компилировать или C2XBTRV.C или C2FXBTRV.C интерфейс отдельно от Вашей программы. Или подключайте результирующие объектные модули, когда Вы компануете Ваши программы, или инсталируйте объектную программу в библиотечный файл, который Вы можете подключать к Вашему редактору связей.</p>
<p>  * Вы можете подключать исходную программу интерфейса, содержащуюся или в C2XBTRV.C или в C2FXBTRV.C, к исходному тексту Вашей прикладной программы при компиляции Вашей программы.</p>
<p>ЯЗЫК АССЕМБЛЕР</p>
<p>Если вы используете ассемблер, Ваша прикладная программа должна применять механизм динамической компановки OS/2 для получения доступа к Btrieve-программам. Пользуйтесь следующим руководством при создании интерфейса на ассемблере для OS/2:</p>
<p>  * Посылайте все параметры в стек.</p>
<p>  * Используйте регистр AX для получения кода возвраиа из</p>
<p>Btrieve.</p>
<p>  * Используйте форму selector:offset (селектор:смещение) для всех адресов интерфейса.</p>
<p>  * Используйте FAR CALL для доступа к программе редактора динамических связей.</p>
<p>  * Не извлекайте возвращаемые параметры из стека.</p>
<p>  * Задавайте имя программы редактора динамческих связей символами верхнего регистра.</p>
<p>КОМПАНОВКА ПРИКЛАДНЫХ ПРОГРАММ OS/2</p>
<p>Внешние ссылки к программам редактора динамических связей одинаково разрешены и для C и для ассемблера.</p>
<p>Вы должны обеспечить редактору связей библиотеку BTRCALLS.LIB при компановке Ваших объектных файлов. Библиотека содержит записи-определения динамических связей, обеспечивающих соответствие между вызываемой программой и файлом BTRCALLS.DLL. если редактор связей не имеет доступа к BTRCALLS.LIB, он сообщит о недопустимой компановке для точек входа редактора динамических связей.</p>
<p>------------------------------------</p>
<p class="note">Примечание:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Для домашних прикладных программ Вы должны использовать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; интерфейс C2FXBTRV.C, скомпоновать Вашу прикладную</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; программу и затем запустить утилиту OS/2 BIND. Программа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; BUTIL.EXE - пример прикладной программы FAPI.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; -----------------------------------------------------------</p>
<p>ИНТЕРФЕЙС С BROUTER</p>
<p>Если Вы создаете VAP, использующий Btrieve-файлы, Вы должны подключить интерфейс с BROUTER к Вашей программе. Следуйте процедурам, описанным в разделе "Связь Btrieve с ассемблером" со следующими дополнениями:</p>
<p>  * Запрашивайте вызов функции "Get Interrupt Vector" для определения, загружен ли BROUTER.</p>
<p>  * Сохраните уникальный номер ID клиента в регистре AX до выполнения прерывания 7B.</p>
<p>  * Идентифицируйте каждую рабочую станцию, имеющую доступ к</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Вашему VAP, уникальным 2-байтовым номером ID клиента. Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;должны обеспечить этот номер для BROUTER для целей процессов</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;парралелизма и транзакций. Удобный метод для создания номера</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ID клиента - сохранение номера связи рабочей станции в первом</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;байте и уникальное двоичное значение во втором байте.</p>
<p>  * Идентифицируйте Ваш VAP в BROUTER, используя уникальный 2-сивол, ASCII идентификатор в регистре BX. Этот идентификатор отличает Ваш VAP от всех других VAP, имеющих доступ к BROUTER. Свяжитесь с Novell Development Products Division, чтобы получить идентификатор для Вашего VAP. Адрес Novell Development Products Division:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Novell Development Products Division</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 6034 West Courtyard</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Suite 220</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Austin, TX 78730</p>
<p>Обычно Ваш интерфейс с BROUTER должен выполнить все следующие шаги:</p>
<p>  * Проверить, загружен ли BROUTER, с помощью выполнения обращения к функции "Get Interrupt Vector".</p>
<p>  * Сохранить блок Btrieve-параметров в памяти в формате, ожидаемом Record Manager.</p>
<p>  * Сохранить адрес блока Btrieve-параметров в регистре DX.</p>
<p>  * Сохранить номер ID клиента, который является уникальным для каждой рабочей станции, в регистре AX.</p>
<p>  * Сохранить уникальный 2-символ, ASCII идентификатор для VAP, в регистре BX.</p>
<p>  * Выполнить прерывание 7B, которое передает управление из Вашего VAP в BROUTER.</p>
<p>{[logo.gif]} &nbsp;{[eXclusive Banner Network]}{[GooDoo 120]}</p>
<p>{Программы} &#8226;{Железо} &#8226; {Драйверы} &#8226; {Хостинг} &#8226;{Энциклопедия рекламы}</p>
<p>| {&lt;&lt;} | {&lt;} | {&gt;} | {&gt;&gt;}</p>
<p>------------------------------------</p>
<p>ГЛАВА 6. ОПЕРАЦИИ ЗАПИСИ BTRIEVE</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; В этой главе описаны все 36 операций, которые может выполнять</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ваша прикладная программа при использовании Btrieve. Для каждой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операции в этой главе представлена следующая информация:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Назначение операции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Таблица, иллюстрирующая значения параметров ожидаемых Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; от Вашей прикладной программы и посылаемых Btrieve в Вашу</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; прикладную программу.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Описание действия операции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Предварительные условия, которым должна удовлетворять Ваша</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; прикладная программа для успешного выполнения операции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Процедура инициализации параметров, требуемых для выполнения</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; операции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Результаты успешного и ошибочного завершения операции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Эффект, оказываемый операцией на Вашу текущую позицию в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; файле.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Таблица параметров содержит шесть параметров Btrieve, включая</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; блок позиции и буфер данных. В Бейсике эти два параметра</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; объединены в один FCB параметр в интерфейсе Бейсика. При каждом</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; вызове Btrieve Ваша прикладная программа должна посылать в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve все параметры, требуемые для используемого Вами языка,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; даже если Btrieve не ждет значения какого-либо параметра или не</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; посылает значение какого-либо параметра.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Параметр статуса не показан в таблице, т.к. Btrieve устанавливает</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; его одним и тем же образом для всех операций. До вызова Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; не ожидает инициализации статуса от Вашей прикладной программы и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; всегда возвращает значение статуса в Вашу прикладную программу.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Примеры программ, иллюстрирующие каждую операцию для Pascal,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; COBOL, C и BASIC включены в Приложения C, D, E и F.</p>
<p>ABORT TRANSACTION (21)</p>
<p>(Отмена транзакции)</p>
<p>Н а з н а ч е н и е :</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Abort Transaction отменяет все операции, выполненные с начала</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; активной транзакции и завершает транзакцию.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>О п и с а н и е :</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ваша прикладная программа может выполнять операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Abort Transaction , чтобы завершить прерванную транзакцию.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Abort Transaction &nbsp;отменяет все операции, выполненные после</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; начала предыдущей операции Begin Transaction, и завершает текущую</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; транзакцию.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До выполнения в Вашей прикладной программе операции Abort</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Transaction должны быть выполнены следующие предварительные</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вы должны задать файл контроля достоверности транзакции</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (используя опцию запуска /T) при загрузке Btrieve&amp;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вы должны успешно выполнить операцию Begin Transaction до</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; выполнения операции &nbsp;Abort Transaction.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции &nbsp;Abort Transaction установите код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операции 21 до выполнения вызова Btrueve. Btrieve проигнорирует</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; все остальные параметры при вызове Abort Transaction.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Abort Transaction завершилась успешно, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; возвратит код статуса равный 0. Все операции Insert(2), Update(3)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; и Delete(4), выполненные с начала транзакции будут удалены из</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файлов.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Abort Transaction завершится с ошибками Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; возвратит ненулевой код статуса, указывающий на причину ошибки.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Наиболее распространенные ненулевые коды статуса для этой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операции:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 36 &nbsp;Нет конфигурации для транзакций.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 39 &nbsp;Нет Begin Transaction</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Abort Transaction не оказывает влияния на</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; позиционирование.</p>
<p>BEGIN TRANSACTION (19)</p>
<p>(Начало транзакции)</p>
<p>Н а з н а ч е н и е :</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Begin Transaction помечает начало множества логически</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; связанных Btrieve-операций.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Begin Transaction определяет начало транзакции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Транзакции полезны, когда Вам необходимо выполнить множество</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve-операций для записи единственного события и если Ваша</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; база данных несовместима, если все операции не завершены.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Транзакция может включать любое число Btrieve-операций над не</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; более чем 12 файлами. Заключая множество операций между Begin и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; End Transaction Вы можете быть уверены, что Btrieve не запишет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; какую-либо из этих операций до тех пор, пока не будут успешно</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; завершены все операции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа запросит операцию,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; должны быть выполнены следующие предварительные условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вы должны задать файл контроля достоверности транзакци при</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; конфигурации BSERVER.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Ваша прикладная программа должна закончить или отменить все</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; предыдущие транзакции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения Begin Transaction установите код операции в 19 до</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; вызова Btrieve. Btrieve проигнорирует все другие параметры при</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; вызове Begin Transaction.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Begin Transaction завершилась успешно, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; вернет код статуса равный 0.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция завершится с ошибками, Btrieve вернет ненулевой код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статуса. Наиболее распространееные ненулевые коды статуса для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; этой операции:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 36 &nbsp;Нет конфигурации для транзакций</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 37 &nbsp;Транзакция не активна</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Begin Transaction не оказывает влияния на</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; позиционирование.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; CLEAR OWNER (30)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Очистить владельца)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Clear Owner удаляет имя владельца, связанное с Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файлом.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Clear Owner удаляет имя владельца, присвоенное Вами файлу</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операцией Set Owner. Если предварительно данные были зашифрованы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve расшифрует данные во время операции Clear Owner.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа запросит операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Clear Owner должны быть выполнены следующие предварительные</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Btrieve-файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Имя владельца должно быть присвоено файлу.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Не должно быть активных транзакций.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Clear Owner установите следующие Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции в 30.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте блок позиции, идентифицированный с файлом, который</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Вы хотите очистить</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; После операции Clear Owner Btrieve больше не запрашивает имя</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; владельца при попытке открыть файл. Если Вы предварительно</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; зашифровали данные в Btrieve-файле,когда задавали владельца,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve расшифрует данные во время операции Clear Owner &nbsp;Чем</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; больше данных должен расшифровать Btrieve, тем дольше выполняется</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операция Clear Owner.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Наиболее распростанееные ненулевые коды статуса для этой операции</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;3 &nbsp;Файл не открыт</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;41 &nbsp;Операция недопустима</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Clear Owner не оказывает эффекта на позиционирование.</p>
<p>CLOSE (1)</p>
<p>(Закрыть)</p>
<p>Н а з н а ч е н и е :</p>
<p>Операция Close закрывает Btrieve-файл.</p>
<p>П р и м е н е н и е п а р а м е т р о в :</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>О п и с а н и е :</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; При завершении Вашей задачей доступа к Btrieve-файлу необходимо</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; выполнить операцию Close. Эта операция закрывает файл, связанный</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; с заданным блоком позиции и отменяет все запреты, наложенные</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; прикладной задачей на файл. После операции Close Ваша прикладная</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; программа не может вновь иметь доступ к файлу до объявления</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; другой операции Open для этого файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа запросит операцию Close</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; должны быть выполнены следующие предварительные условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Btrieve-файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Все транзакции должны быть закончены или отменены.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения этой операции установите следующие Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Установите код операции в 1.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте достоверный блок позиции для файла, который Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; хотите закрыть</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Close завершилась успешно, произойдет следующее:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Блок позиции дя закрытого файла не будет больше достоверным.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Ваша прикладная программа может использовать его для другого</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; файла или может использовать область данных для других целей.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Close завершилась ошибочно, файл останется открытым</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Наиболее распростанееный ненулевой код статуса для этой операции</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статус 3 (файл не открыт).</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Close удаляет всю позиционную информацию, связанную с файлом.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; CREATE (14)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Создать)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Create создает Btrieve-файл с заданным набором</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; характеристик.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; x &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp;x &nbsp; &nbsp; &#166; &nbsp; x &nbsp;&#166; &nbsp;x &nbsp;&#166; &nbsp;x</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Create позволяет Вам создать Btrieve-файл из Вашей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; прикладной программы. Она выполняет ту же функцию, что и утилита</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; CREATE, описанная в Главе 3. См. Главы 3 и 4 этого руководства</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; для дополнительной информации о характеристиках файлов и ключей,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; которые требуется задать при создании файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующие разделы описывают как хранить определение Btrieve-файла</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; в буфере данных. Порядок, в котором должны хранится различные</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; спецификации файла и ключей, приведены в таблице. За таблицей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; следуют разделы, описывающие как задавать:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Спецификации файла</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Характеристики ключей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Альтернативну последовательность поиска</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; _ Длину буфера данных</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve ожидает, что буфер данных будет отформатирован как</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; показано в Таблице 6.1.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; Описание &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;Длина&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; +-----------------------+-----+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; длина записи &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp;2 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; размер страницы &nbsp; &nbsp; &nbsp; &#166; &nbsp;2 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;спецификации &nbsp; &#166; кол-во индексов &nbsp; &nbsp; &nbsp; &#166; &nbsp;2 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; файла &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; не используется &nbsp; &nbsp; &nbsp; &#166; &nbsp;2 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; флаги файла &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp;4 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; резервное слово &nbsp; &nbsp; &nbsp; &#166; &nbsp;2 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; размещение &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp;2 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; L-----------------------+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; Описание &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Длина&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; +-----------------------T-----+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; позиция ключа &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp;2 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; длина ключа &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp;2 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;спецификации &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ключей &nbsp; &nbsp; &nbsp; &#166; флаги ключа &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp;2 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(повторяются) &nbsp;&#166; не используется &nbsp; &nbsp; &nbsp; &#166; &nbsp;4 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; тип расширенного ключа&#166; &nbsp;4 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; пустое значение &nbsp; &nbsp; &nbsp; &#166; &nbsp;2 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; зарезервировано &nbsp; &nbsp; &nbsp; &#166; &nbsp;2 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; L-----------------------+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Таблица 6.1</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Структура буфера данных для операции Create</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; С п е ц и ф и к а ц и и &nbsp; ф а й л а . Храните спецификации файла</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; в первых 16 байтах буфера данных. Байты пронумерованы начиная с 0</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Храните информацию о длине записи, размере страницы и количестве</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; индексов как целые. Для создания файла, состоящего только из</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; данных, установите число индексов в ноль.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы должны разместить "неиспользуемые" и "зарезервированные"</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; области буфера данных, даже если Btrieve не использует их в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операции Create. Инициализируете зарезервированные области нулем,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; чтобы обеспечить совместимость с будующими версиями Btrieve.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Установка битов в слове флагов файла задает, допускает ли файл</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; записи переменной длины, усечение пробелов или сжатие данных, и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; должен ли Btrieve перераспределять дисковое пространство для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файла, Используйте два старших бита младшего айта для задания</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; границы свободного пространства для страниц переменной длины.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Биты в слове флагов файла пронумерованы с 0 до 15, начиная с 0</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; бита. Установите биты в соответствии со следующим описанием:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 0 = 1, Btrieve позволит файлу содержать записи</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; переменной длины.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 1 = 1, Btrieve усечет пробельные концы в записях</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; переменной длины.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 2 = 1, Btrieve перераспределит количество страниц,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; заданных Вами в слове распределения.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 3 = 1, Btrieve сожмет данные в файле.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 4 = 1, Btrieve создаст файл, состоящий только из</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ключей.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 6 = 1, Btrieve установит 10% границу свободного</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; пространства для страниц записей переменной длины.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 7 = 1, Btrieve установит 20% границу свободного</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; пространства для страниц записей переменной длины.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 6 = 1 и бит 7 = 1, Btrieve установит 30% границу</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; свободного пространства для страниц записей переменной длины.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующая таблица показывает двоичное и десятичное представление</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; значений флагов файла:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Значения &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Двоичное &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Десятичное</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; переменная длина &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 00000001 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 1</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; усечение пробелов &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;00000010 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; перераспределение &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;00000100 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 4</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; сжатие данных &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;00001000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 8</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; только ключи &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 00010000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;16</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 10% свободное пространство &nbsp; 01000000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;64</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 20% свободное пространство &nbsp; 10000000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 128</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 30% свободное пространство &nbsp; 11000000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 192</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если Вам необходимо задать комбинацию из атрибутов файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; добавьте соответствующее значение флага. Например, для задания</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файла, допускающего записи переменной длины и усечение пробелов,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; инициализируйте флаги файла значением 3 (2+1). Btrieve игнорирует</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; флаги усечение пробелов и грницы свободного пространства, если</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; флаг переменной длины установлен в 0.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если Вы устанавливаете бит флага перераспределения, используйте</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; слово распределения для хранения целого значения, задающего число</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; страниц, которое Вы хотите перераспределить файлу.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Х а р а к т е р и с т и к и &nbsp; к л ю ч а . Поместите характеристики</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ключей после блока спецификации файла. Назначьте 16-битовый блок</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; спецификации ключа для каждого сегмента ключа в файле. Код типа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; расширенного ключа и пустой символ имеют длину в 1 байт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Храните информацию для позиции ключа и длины ключа как целые.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Установите флаги ключа для задания атрибутов, нужных Вам для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ключа, в соответствии со следующим описанием:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 0 = 1, ключ допускает дубликаты.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 1 = 1, ключ - модифицируемый.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 2 = 0 и бит 8 = 0, ключ - строковый.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 2 = 1 и бит 8 = 0, ключ - двоичный.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 3 = 1, ключ имеет пустое значение.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 4 = 1, ключ имеет другой сегмент.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 5 = 1, ключ отсортирован с помощью последовательности</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; альтернативного поиска.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 6 = 1, ключ отсортирован в убывающем порядке.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Бит 7 игнорируется для операции Create.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 8 = 0, ключ - стандартного типа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 8 = 1, ключ - расширенного типа,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 9 = 1, ключ - ручной.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Хотя Btrieve игнорирует бит 7 для операции Create, Вы должны</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; инициализировать его значением 0 при создании файла. Когда Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; объявите операцию Stat (15), Btrieve установит бит 7 в 1, если</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ключ имеет дополнительный индекс и возвратит флаги ключа в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; буфер данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Следующая таблица показывает двоичные, шестнадцетиричные и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; десятичные значения флагов ключа:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Атрибут &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Двоичное &nbsp; Шестнадцатиричное &nbsp; Десятичное</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; двойной &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 00000001 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;01 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; модифицируемый &nbsp; &nbsp; &nbsp;00000010 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;02 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; двоичный &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;00000100 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;04 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;4</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; пустой &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;00001000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;08 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;8</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; сегментированный &nbsp; &nbsp;00010000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 16</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; альт.посл.поиска &nbsp; &nbsp;00100000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;20 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 32</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; убывающий &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 01000000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;40 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 64</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; дополнительный &nbsp; &nbsp; &nbsp;10000000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;80 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;128</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; расширенного типа 1 00000000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 100 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;256</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ручной &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 10 00000000 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 200 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;512</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Присваивайте одни и те же атрибуты двойной, модифицируемый и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; пустой для всех сегментов одного и того же ключа. Если Вы задаете</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; пустой атрибут для ключа, Вы должны присвоить различные пустые</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; характеристики для отдельных сегментов.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Атрибут сегментированного ключа - флаг, показывающий что блок</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; следующего ключа в буфере данных ссылается на следующий сегмент</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; этого же ключа. Кроме того, Вы можете сделать каждый сегмент</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ключа или возрастающим или убывающим и задать любой тип данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Например, для создания файла с двумя ключами, первый из которых</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; состоит из двух сегментов, а второй - из одного сегмента,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; используйте бит 4 флагов ключа следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - В первом блоке ключей установите бит 4 слова флагов ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; в 1, показывающую что за этим ключом следует определение</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; другого ключевого сегмента.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Во втором блоке ключей установите бит 4 слова флагов ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; в 0, показывающий что этот блок ключей определяет последний</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; сегмент первого ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - В третьем блоке ключей установите бит 4 слова флагов ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; в 0, показывающую что второй ключ имеет только один сегмент.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Задайте тип расширенного ключа как двоичное значение в байте 10</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; блока спецификации ключей. Значения типов расширенных ключей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; показаны ниже:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Тип &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Значение</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;string (строка) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;0</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;integer (целое) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;float (с плавающей запятой) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;date (дата) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;3</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;time (время) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 4</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;decimal (десятичное) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 5</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;money (деньги) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 6</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;logical (логическое) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 7</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;numeric (числовое) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 8</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;bfloat &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 9</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;lstring (l-строка) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;zstring (z-строка) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;11</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;unsigned binary (двоичное без знака) &nbsp; &nbsp; &nbsp;14</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;autoincrement (автоинкремент) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 15</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Как и в случае флагов файла Вы можете задать комбинации</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; атрибутов ключей складывая соответствующие им значения флагов.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Например, если ключ - расширенного типа, часть сегментированного</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ключа и должен быть отсортирован в убывающем порядке, Вы должны</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; будете хранить 150H (336 десятичное) в слове флагов.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;--------------------------------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Примечание:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Вы можете определить типы расширенного ключа "строка" и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;"двоичное без знака" как стандартные типы так и как</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;расширенные типы. Это обеспечивает совместимость с</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;прикладными программами, написанными для ранних версий</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Btrieve, в то время как в новых прикладных программах</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;допустимо использовать исключительно типы расширенных</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ключей.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;--------------------------------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; А л ь т е р н а т и в н а я &nbsp;п о с л е д о в а т е л ь н о с т ь</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; п о и с к а . Вы можете задать альтернативную последовательность</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; поиска для сортировки по любому числу ключевых сегментов файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Однако, Вы можете задать только ОДНУ альтернативную</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; последовательность поиска для всего файла. Вы можете задать, что</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; некоторые сегменты одного ключа &nbsp;должны быть отсортированы в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; стандартной ASCII последовательности поиска, а другие сегменты</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; должны быть отсортированы в альтернативной последовательности.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете задать альтернативную последовательность поиска для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ключа типа "l-строка", " z-строка" и "строка". Если Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; устанавливаете флаг альтернативной последовательности поиска для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; всех ключей или сегментов ключа в файле, поместите определение</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; последовательности поиска непосредственно за последним блоком</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; спецификации ключей.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т.е. актуальная последовательность поиска сама должна следовать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; за блоком спецификации ключей вместо имени файла, содержащего</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; эту последовательность. Определение альтернативной</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; последовательности поиска состоит из девяти байтов заголовка, за</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; которыми следуют 256 символов, как это описано в разделе</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; "Альтернативная последовательность поиска" в Главе 4.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;--------------------------------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Примечание:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Если Вы создаете множество файлов с различными</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;альтернативными последовательностями поиска, используйте</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;разные имена для каждой последовательности.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;--------------------------------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Д л и н а &nbsp; б у ф е р а &nbsp; д а н н ы х. Длина буфера данных должна</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; быть достаточной для включения спецификаций файла, характеристик</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ключей и альтернативной последовательности поиска, если она</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; задана. НЕ задавайте длину записи файла в этом параметре.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Например, для создания файла с двумя ключами, каждый из которых</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; имеет по одному сегменту, и с альтернативной последовательностью</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; поиска, буфер данных для операции Create должен иметь длину по</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; крайней мере 313 байтов, как показано ниже:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Спец. &nbsp; &nbsp; Спец. &nbsp; &nbsp; &nbsp; Спец. &nbsp; &nbsp; &nbsp; Альт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; файла &nbsp;+ &nbsp;ключа 1 &nbsp;+ &nbsp;ключа 2 &nbsp;+ &nbsp;П-ть</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ________________________________________</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;16 &nbsp; &nbsp;+ &nbsp; 16 &nbsp; &nbsp; &nbsp;+ &nbsp; &nbsp;16 &nbsp; &nbsp; + &nbsp; 265 &nbsp; &nbsp; = &nbsp;313</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н о м е р &nbsp; к л ю ч а . &nbsp;Вы можете использовать параметр номера</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ключа для того, чтобы задать хотите ли Вы, чтобы Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; предупредил Вас о существовании файла с тем же именем. Задайте</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; значение номера ключа следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - ЕСЛИ ВЫ НЕ ХОТИТЕ, ЧТОБЫ BTRIEVE СОЗДАВАЛ НОВЫЙ ФАЙЛ ВМЕСТО</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; СУЩЕСТВУЮЩЕГО, установите параметр номера ключа в -1. Если</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; файл с тем же самым именем уже существует, Btrieve вернет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ненулевой статус и не будет создавать новый файл.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - ЕСЛИ ВЫ ХОТИТЕ, ЧТОБЫ BTRIEVE СОЗДАВАЛ НОВЫЙ ФАЙЛ ВМЕСТО</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; СУЩЕСТВУЮЩЕГО, ИЛИ ЕСЛИ ВЫ НЕ ХОТИТЕ ПРОВЕРЯТЬ НАЛИЧИЕ</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; СУЩЕСТВОВАНИЯ ФАЙЛА, установите параметр номера ключа в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ненулевое значение, предпочтительно в 0.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если Вы создаете пустой Btrieve-файл вместо ранее</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; существовавшего Btrieve-файла, будьте уверены, что файл закрыт</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; перед выполнением операции Create.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Create установите следующие Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции в 14.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте спецификации файла, характеристики ключей и все</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; альтернативные последовательности поиска в буфере данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Все значения для спецификации файла и характеристики ключей,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; хранимые в буфере данных, должны быть в двоичном формате.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте длину буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите параметр номера ключа в -1, если Вы хотите, чтобы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Btrieve предупредил Вас о существовании файла с тем же самым</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; именем. Иначе, установите параметр номера ключа в 0.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте имя файла в буфере ключа. Удостовертесь, что имя</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; файла завершается пробелом или двоичным нулем. Вы можете</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; задать имя устройства и путь для файла, включая любое число</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; уровней директорий.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция завершилась успешно Btrieve предупредит Вас о</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; существовании файла с тем же самым именем или создаст новый файл</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; согласно Вашим спецификациям. Новый файл не будет содержать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; записей. Операция Create не открывает файл. Ваша прикладная</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; программа должна выполнить операцию Open до того, как файл станет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; доступен.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция завершилась безуспешно, Btrieve вернет ненулевой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; код статуса, информирующий о причине. Наиболее часто встречающие</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевые коды:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;2 Ошибка ввода/вывода файла</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 22 Буфер данных слишком мал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 24 Ошибка размера страницы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 25 Ошибка ввода/вывода при создании</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 26 Число ключей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 27 Неверная позиция ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 28 Неверная длина записи</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 29 Неверная длина ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 48 Неверное определение альтернативной последовательности</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 49 Ошибка типа ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 59 Файл уже существует</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; См. в Приложении B объяснение кодов статуса.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Create не устанавливает какую-либо позиционную</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; информацию.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; CREATE SUPPLEMENTAL INDEX</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Создание дополнительного индекса)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Create Supplemental Index добавляет дополнительный</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; индекс в файл.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; x &nbsp; &nbsp; &nbsp;&#166; &nbsp;x &nbsp; &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Применяйте операцию Create Supplemental Index для добавления</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; индекса в файл в любое время после того, как ббыл создан файл.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа запрсит операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Create Supplemental Index, должны быть выполнены следующие</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; предварительные условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Btrieve-файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Количество существующих сегментов ключа в файле должно быть</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; меньше или равно следующей формуле:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 24 - (число сегментов, которые надо добавить)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Флаги ключей, позиция и длина нового индекса должны</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; соответствовать файлу, в который Вы добавляете индекс.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Не должно быть активных транзакций.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для создания дополнительного индекса установите следующие</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve-параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции в 31.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Пошлите Btrieve блок позиции для файла, в который Вы хотите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; добавить индекс.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохраните спецификации ключа для нового индекса в буфере</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; данных. Буфер данных состоит из 16-байтового блока</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; спецификации ключа для каждого сегмента создаваемого Вами</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; дополнительного индекса. Используйте ту же самую структуру</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; как в блоке спецификации ключа, используемом в &nbsp;операции</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Create (14).</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите параметр длины буфера данных равным количеству</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; байтов в буфере данных. Для нового индекса без альтернативной</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; последовательности поиска используйте следующую формулу для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; определения правильной длины буфера данных:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;16 * &nbsp;(число сегментов)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Если новый ключ имеет альтернативную последовательность</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; поиска, используйте следующую формулу для определения</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; правильной длины буфера данных:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;16 * &nbsp; (число сегментов) + 265</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve немедленно начнет добавлять новый индекс в файл. Время,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; требуемое для этой операции, зависит от общего числа записей,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; которые будут индексированы, размера файла и длины нового индекса.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Номер ключа нового индекса на единицу больше, чем номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; предыдущего самого старшего ключа. Вы можете использовать новый</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; индекс для доступа к Вашим данным сразу по завершении операции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если Btrieve не может создать дополнительный индекс по какой-либо</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; причине, он вернет ненулевой статус показывающий причину и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; отбросит часть дополнительного индекса, которая уже построена.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Страницы файла, размещенные в дополнительном индексе до ошибки</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; будут помещены в список свободного пространства файла и будут</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; повторно использованы, когда Вы добавляете записи или создаете</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; другой дополнительный индекс.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Наиболее часто встречающие ошибки:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 22 Буфер данных слишком мал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 27 Неверная позиция ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 28 Неверная длина записи</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 41 Недопустимая операция</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 45 Несуществующие флаги ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 49 Ошибка типа ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 56 Незавершенный индекс</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если во время создания дополнительного индекса отключится питание</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; или система перезагрузится, Вы сможете получить доступ к данным</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файла через другие индексы файла. Однако, Btrieve вернет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевой статус, если Вы попытаетесь получить доступ к данных</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; через незавершенный индекс. В этом случае отбросьте незавершенный</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; индекс с помощью операции Drop Supplemental Index (32) и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; запросите операцию Create Supplemental Index.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Create Supplemental Index не оказывает эффекта на</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; позиционирование.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; DELETE (4)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Удалить)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Delete удаляет существующую запись из Btrieve-файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp;x &nbsp; &#166; &nbsp; &nbsp; &#166; &nbsp;x</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp;x &nbsp; &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете удалить существующую запись из файла, используя</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операцию Delete. После удаления пространство в файле, где</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; хранилась удаленная запись, помещается в список свободного</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; пространства.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа запрсит операцию Delete</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; должны быть выполнены следующие предварительные условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл данных должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вы не должны обращаться к файлу, содержащему запись для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; удаления, между поиском этой записи и ее удалением.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Delete установите следующие Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте код операции равный 4.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте Btrieve блок позиции файла, из которого должна</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; быть удалена запись.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Проинициализируйте параметр длины буфера данных величиной,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; равной длине удаляемой записи.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохраните номер ключа, используемый для поиска записи, в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; параметре номера ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Delete завершилась успешно, Btrieve:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Полностью удалит запись из файла;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Обновит все индексы ключей, чтобы отразить удаление;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установит длину буфера данных равной длине удаленной записи.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если невозможно успешно удалить запись, Btrieve возвратит</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевой код статуса.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Наиболее часто встречающие ошибки:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 7 Другой номер ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 8 Неверное позиционирование</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; После операции Delete Btrieve удаляет всю существующую</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; позиционную информацию и устанавливает позицию в файле</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если существует дубликат, СЛЕДУЮЩЕЙ записью становится</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; первый дубликат, следующий за удаленной записью. Иначе,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; следующей записью становится первая запись со значением</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ключа большим, чем значение ключа удаленной записи.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если существует дубликат, ПРЕДЫДУЩЕЙ записью становится</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; предыдущий дубликат с этим значением ключа. Иначе,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; предыдующей записью становится последняя запись данных для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; предыдущего значения ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; DROP SUPPLEMENTAL INDEX (32)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Отбросить дополнительный индекс)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Drop Supplemental Index удаляет дополнительный индекс</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; из существующего Btrieve-файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166; &nbsp;x</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Используйте операцию Drop Supplemental Index для удаления</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; дополнительного индекса из файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа запрсит операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Drop Supplemental Index, должны быть выполнены следующие</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; предварительные условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Дополнительный индекс должен существовать в файле.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Не должно быть активных транзакций</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для отбрасывания дополнительного индекса установите следующие</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve-параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции равный 32.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте блок позиции Btrieve-файла</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохраните номер ключа для дополнительного индекса, который</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Вы хотите отбросить, в параметре номера ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Drop Supplemental Index завершилась успешно,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Поместит страницы файла, размещенные для этого индекса, в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; список свободного пространства для дальнейшего использования;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Декриментируйте (уменьшите на один) номера ключей всех</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; других дополнительных индексов с номерами ключей старшими,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; чем отбрасываемый индекс.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция не была успешной, Btrieve возвратит ненулевой код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статуса в Вашу прикладную программу. Наиболее часто встречающиеся</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевые коды статуса для этой операции:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;6 Неверный номер ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 41 Недопустимая операция</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если процесс прерван во время отбрасывания индекса. Вы можете</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; получить доступ к данным файла через другие индексы файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve возвратит код статуса 56 (Незавершенный индекс), если Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; попытаетесь получить доступ к файлу через незавершенный индекс. В</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; этом случае запросите вновь операцию Drop Supplemental Index.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Drop Supplemental Index не оказывает эффект на</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; позиционирование.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; END TRANSACTION (20)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Конец транзакции)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; End Transaction завершает транзакцию и делает соответствующие</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; изменения в файлах данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; End Transaction отмечает завершение набора логически связанных</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve-операций.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа запрсит операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; End Transaction, она должна выполнить успешно операцию Begin</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Transaction (19).</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции End Transaction установите код операции</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; равный 20. Btrieve проигнорирует все другие параметры вызова</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; End Transaction.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция End Transaction завершилась успешно, все операции</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ограниченные этой транзакцией будут записаны в Вашу базу данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ваша прикладная программа не может отменить транзакцию после</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операции End Transaction.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция не была успешной, Btrieve возвратит ненулевой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статус. Наиболее часто встречающийся ненулевой код статуса - код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; 38 (Ошибка управления транзакциями файла), которая появляется,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; если файл управления транзакциями был удален или не мог быть</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; записан по какой-либо причине.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция End Transaction не оказывает эффект на позиционирование.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; EXTEND (16)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Расширить)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Extend разделяет файл на два логических устройства.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp;x &nbsp;&#166; &nbsp;x</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Extend позволяет Вашей прикладной программе</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; распространять один Btrieve-файл на второе логическое устройство.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа запрсит операцию Extend,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; должны быть выполнены следующие предварительные условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Btrieve должен иметь доступ к тому, на который будет расширен</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; файл.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Не должно быть активных транзакций.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Extend установите следующие Btrueve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции равный 16.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте блок позиции для расширяемого файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохраните имя расширяемого файла в буфере ключа. Задайте</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; имя устройства и имя полного пути файла. Завершайте имя</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; расширяемого файла пробелом или двоичным нулем.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте значение -1 в параметре номера ключа при выполнении</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; операции Extend, если Вы хотите, чтобы Btrieve начал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; немедленно хранить данные в расширяемом файле. Обычно Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; не помещает данные в расширяемый файл до того, как устройство</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; содержащее первоначальный файл не заполнится.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Extend завершилась успешно, Btrieve распространит</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файл на два логических тома. Для получения доступа к расширенному</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файлу пользуйтесь следующим руководством:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Немедленно после расширения файла ваша прикладная задача</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; должна закрыть и открыть вновь файл до того, как она получит</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; доступ к расширению.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Как первоначальное устройство так и устройство расширения</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; должны бвть в "online", когда Ваша программа получает доступ</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; к расширенному файлу. Btrieve должен быть способен найти</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; расширенный файл на заданном Вами логическом устройстве.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - После того, как Вы создали расширенный файл, Вы не можете</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; перемещать его на другое устройство. Когда Вы расширяете файл</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Btrieve пишет имя полного пути, заданного для этого</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; расштрения в адрес первоначального файла данных. Поэтому</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; каждая рабочая станция должна использовать одно и то же</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; определение устройства для ссылки на устройство, содержащее</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; расширяемый файл.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция не была успешной, Btrieve возвратит ненулевой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статус. Наиболее часто встречающиеся ошибки, возвращаемые</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операцией Extend:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 31 Файл уже расширен</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 32 Ошиббка ввода/выода при расширении</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 34 Невернре имя расширения</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Extend не оказывает эффект на позиционирование.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; GET DIRECT (23)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Получить направление)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Direct ищет запись данных, расположенную по заданному</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; физическому адресу в Btrieve-файле.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;x &nbsp; &nbsp; &#166; &nbsp; x &nbsp;&#166; &nbsp; &nbsp; &#166; &nbsp;x</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;x &nbsp; &nbsp; &#166; &nbsp; x &nbsp;&#166; &nbsp;x &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Get Direct позволяет Вашей прикладной программе</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; искать запись, используя ее физическое расположение в файле</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; вместо использования одного из заданных индексных путей.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете использовать Get Direct следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вы можете искать запись быстрее, используя физическое</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; расположение вместо значения ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вы можете использовать операцию Get Direct для поиска</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 4-байтового расположения записи, сохранить расположение и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; затем позже использовать Get Direct для возврата</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; непосредственно в это место.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вы можете использовать 4-байтовое расположение для поиска</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; записи в цепочке дубликатов без повторного чтения всех</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; записей с начала цепочки.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вы можете изменить текущий путь доступа. Операция</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Get Position, следуемая за операцией Get Direct с другим</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; номером ключа, устанавливает позиционирование для текущей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; записи в другом индексном дереве. Get Next возвратит</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; следующую запись в файле, опираясь на новый путь доступа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа запрсит операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Direct, должны быть выполнены следующие предварительные</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Ваша прикладная программа должна предварительно найти</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 4-байтовое расположение записи, запросив операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Get Position.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Get Direct установите следующие Btrueve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции равный 23.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохраните 4-байтовую позицию требуемой записи в первых</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; четырех байтах буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте общую длину буфера данных таким образом, чтобы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Btrieve мог определить, войдет ли запись в Ваш буфер.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте путь доступа, для которого должен установить</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; позиционирование Btrieve, в параметре номера ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Get Direct завершилась успешно, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохранит требуемую запись в буфере данных, переписав</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 4-байтовую точку входа в первых четырех байтах.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохранит актуальную длину записи в параметре длины буфера</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; данных;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохраните значение ключа для заданного ключа доступа в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; буфере ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если Btrieve не может возвратить требуемую запись, он вернет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевой статус. Наиболее часто встречающиеся ненулевые коды</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статуса:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 22 Буфер данных слишком мал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 43 Неверный адрес записи данных</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; После операции Get Direct Btrieve удаляет всю существующую</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; позиционную информацию и устанавливает текущую позицию согласно</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; заданному номеру ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - СЛЕДУЮЩАЯ запись становится следующим дубликатом</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; возвращаемого значения ключа. Иначе, она становится первой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; записью для значения ключа большего, чем требуемое.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - ПРЕДЫДУЩАЯ запись становится или предыдущим дубликатом для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; возвращаемого ключа или последним дубликатом значения ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; меньшего, чем возвращаемое.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; GET DIRECTORY (18)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Получить директорию)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Directory ищет текущую директорию.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166; &nbsp;x</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp;x &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Get Directory возвращает текущую директорию для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; заданного логического устройства.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа сможет запрсить операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Directory непосредственно после загрузки Record Manager.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Буфер ключа должен быть по крайней мере длиной в 65 символов.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для поиска текущей директории установите следующие Btrueve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции равный 18.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохраните номер логического устройства в параметре номера</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ключа до вызова Btrieve. Задайте устройство A как 1, 2 для B</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; и т.д. Для использования устройства по умолчанию задайте 0.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve возвратит текущую директорию, завершенную двоичным нулем</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; в буфере ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Get Directory &nbsp;не оказывает эффект на позиционирование.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; GET EQUAL (5)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Получить равную)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Equal ищет запись, соответствующую заданному значению ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp;x &nbsp;&#166; &nbsp;x</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; x &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Используя операцию Get Equal, Ваша прикладная программа может</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; искать запись, опираясь на значение ключа заданное в буфере</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа сможет запрсить операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Equal должны быть выполнены следующие предварительные</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл не может быть файлом, состоящим только из данных без</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; определенных индексов.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции установите следующие Btrueve-параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Проинициализируйте код операции значением 5.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте блок позиции для файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте требуемое значение ключа в буфере ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите номер ключа в правильный путь доступа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Проинициализируйте длину буфера данных значением равным длине</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; записи, которую Вы хотите найти.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Get Equal завершилась успешно, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вернет требуемую запись в буфер данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вернет длину записи в байтах в параметр длины буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Get Equal не была успешной,Btrieve вернет ненулевой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; код статуса указывающий на причину. Наиболее часто встречающиеся</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевые коды статуса:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;3 Файл не открыт</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;4 Не найдено значение ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 22 Буфер данных слишком мал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; После операции Get Equal Btrieve удаляет всю существующую</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; позиционную информацию и устанавливает свою позицию в индексе</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если дубликат существует, СЛЕДУЮЩАЯ запись становится первым</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; дубликатом возвращаемого значения ключа. Иначе, следующая</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; запись становится первой записью для значения ключа большего,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; чем требуемое.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - ПРЕДЫДУЩАЯ запись становится последним дубликатом значения</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ключа меньшего, чем возвращаемое. Если не существует</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; дубликатов, предыдущая запись становится единственной записью</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; для значения ключа меньшего, чем возвращаемое.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; GET FIRST (12)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Получить первую)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get First ищет запись, соответствующую первому значению ключа для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; заданного пути доступа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp; &nbsp; &#166; &nbsp;x</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; x &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp;x &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Get First позволяет Вашей прикладной программе искать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; запись, соответствующую первому значению ключа для заданного</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; номера ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа сможет запрсить операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get First должны быть выполнены следующие предварительные</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл не может быть файлом, состоящим только из данных без</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; определенных индексов.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции установите следующие Btrueve-параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Проинициализируйте код операции значением 12.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте блок позиции для файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте номер ключа для данного пути доступа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте длину буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Get First завершилась успешно, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вернет требуемую запись в буфер данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохранит соответствующее значение ключа в буфере данных;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вернет длину записи в параметр длины буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Get First не была успешной, Btrieve вернет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевой код статуса указывающий на причину. Наиболее часто</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; встречающиеся ненулевые коды статуса:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;3 Файл не открыт</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;6 Неверный номер ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 22 Буфер данных слишком мал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; После операции Get First Btrieve удаляет всю существующую</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; позиционную информацию и устанавливает свою позицию в индексе</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - ПРЕДЫДУЩАЯ запись указывает за начало файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - СЛЕДУЮЩАЯ запись становится следующим дубликатом</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; возвращаемого значения ключа или, если не существует</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; дубликатов, первой записью для значения ключа большего, чем</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; возвращаемое.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; GET GREATER (8)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Получить большую)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Greater ищет запись, соответствующую значению ключа большего</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; чем заданное значение ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp;x &nbsp;&#166; &nbsp;x</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; x &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp;x &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Используя операцию Get Greater Ваша прикладная программа может</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; поднять путь доступа, задавая номер ключа для нахождения первого</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; значения ключа большего, чем задано в буфере ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа запросит операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Greater, должны быть выполнены следующие предварительные</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл не может быть файлом, состоящим только из данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Get Greater установите следующие</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve-параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции равный 8.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте блок позиции для файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохраните значение ключа в параметре буфера ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите параметр номера ключа в соответствии с правильным</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; путем доступа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте длину буфера данных.</p>
<p>Р е з у л ь т а т :</p>
<p>Если операция завершилась успешно, Btrieve</p>
<p>  * Вернет соответствующую запись в буфер данных.</p>
<p>  * Вернет длину записи в параметр длины буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция не была успешной, Btrieve вернет ненулевой код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статуса, указывающий на причину. Наиболее часто встречающиеся</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевые коды статуса:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;3 Файл не открыт</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;6 Неверный номер ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 22 Буфер данных слишком мал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; После операции Get Greater Btrieve удаляет всю существующую</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; позиционную информацию и устанавливает свою позицию в индексе</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если дубликат существует, СЛЕДУЮЩАЯ запись становится</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; первым дубликатом возвращаемого значения. Иначе, следующая</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; запись становится первой записью для значения ключа большего,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; чем возвращаемое.</p>
<p>  * ПРЕДЫДУЩАЯ запись становится последним дубликатом значения ключа меньшего возвращаемого. Иначе, предыдущая запись становится единственной записью для значения ключа меньшего, чем возвращаемое.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; GET GREATER OR EQUAL (9)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Получить большую или равную)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Greater Or Equal ищет запись со значением ключа большим или</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; равным заданному значению ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp;x &nbsp;&#166; &nbsp;x</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; x &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp;x &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Get Greater Or Equal позволяет Вашей прикладной</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; программе находить запись или равную или большую чем заданное</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; значение ключа. Btrieve сперва ищет значение ключа равное</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; заданному значению. Если Btrieve не может найти равное значение</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ключа, он поднимает путь доступа до тех пор. пока он не найдет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; запись со следующим старшим значением ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа запросит операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Greater Or Equal, должны быть выполнены следующие</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; предварительные условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл не может быть файлом, состоящим только из данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Get Greater Or Equal установите следующие</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve-параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции равный 9.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте блок позиции для файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохраните значение ключа в параметре буфера ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите параметр номера ключа в соответствии с правильным</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; путем доступа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте длину буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция завершилась успешно, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вернет соответствующую запись в буфер данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вернет длину записи в параметр длины буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция не была успешной, Btrieve вернет ненулевой код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статуса, указывающий на причину. Наиболее часто встречающиеся</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевые коды статуса:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;3 Файл не открыт</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;6 Неверный номер ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 22 Буфер данных слишком мал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; После операции Get Greater Or Equal Btrieve удаляет всю</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; существующую позиционную информацию и устанавливает текущую</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; позицию следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - СЛЕДУЮЩАЯ запись становится первым дубликатом возвращаемого</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; значения ключа, если дубликат существует. Иначе, он</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; становится первой записью для значения ключа большего,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; чем возвращаемое.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - ПРЕДЫДУЩАЯ запись становится последним дубликатом значения</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ключа меньшего возвращаемого, или, если дубликат не</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; существует, единственной записью для значения ключа меньшего,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; чем возвращаемое.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; GET KEY (+50)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Получить ключ)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Key позволяет Вам выполнять операцию Get без действительного</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; поиска записи даных. Вы можете использовать Get Key для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; определения наличия значения в файле. Операция Get Key как правило</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; быстрее, чем соответствующая Get операция. Операция Get Key</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; может быть использована с любой из следующих Get операций:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - GET EQUAL (5)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - GET NEXT (6)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - GET PREVIOUS (7)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - GET GREATER (8)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - GET GREATER OR EQUAL (9)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - GET LESS THAN (10)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - GET LESS THAN OR EQUAL (11)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - GET FIRST (12)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - GET LAST (13)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Параметры - те же самые как и в соответствующей Get операции, за</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; исключением того, что Btrieve игнорирует длину буфера данных и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; не возвращает запись в буфер данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Предварительные условия для операции Get Key - те же самые, что</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; и в соответствующей Get операции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Get Key установите Btrieve-параметры так</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; как бы Вы установили их для соответствующей Get операции. Вам не</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; требуется инициализировать длину буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы должны добавить 50 к коду операции Get, которую Вы хотите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; выполнить. Например, для выполнения операции Get Key (код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операции 50) с операцией Get Equal (код операции 5) используйте</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; 55 для кода операции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если Btrieve найдет требуемый ключ, он возвратит ключ в буфер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ключа и статус равный 0. Иначе, Btrieve возвратит ненулевой код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статуса, показывающий почему он не может найти ключ.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Get Key устанавливает текущее позиционирование точно в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; соответствии с тем, что делает соответствующая Get операция, за</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; исключением того, что Get Next Key и Get Previous Key не</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; возвращает дубликаты.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; GET LAST (13)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Получить последнюю)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Last ищет запись, сооответствующую значению последнего ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; для заданного пути доступа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp; &nbsp; &#166; &nbsp;x</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; x &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp;x &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Используя операцию Get Last Ваша прикладная программа может</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; находить последнюю запись, которая соответствует последнему</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; значению ключа для заданного номера ключа. Если дубликаты</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; существуют для последнего значения ключа, возвращаемая запись</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; будет последним дубликатом.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа запросит операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Last, должны быть выполнены следующие предварительные</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл не может быть файлом, состоящим только из данных без</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; заданных индексов.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения этой операции установите следующие Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Проинициализируйте код операции значением 13.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте блок позиции для файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте длину буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте номер ключа для пути доступа.</p>
<p>Р е з у л ь т а т :</p>
<p>Если операция завершилась успешно, Btrieve</p>
<p>  * Вернет требуемую запись в буфер данных.</p>
<p>  * Сохранит значение соответствующего ключа в буфере ключа;</p>
<p>  * Возвратит длину записи в параметре длины буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если Btrieve не может вернуть запись, он возвратит ненулевой код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статуса, указывающий на причину. Наиболее часто встречающиеся</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевые коды статуса:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;3 Файл не открыт</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;6 Неверный номер ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 22 Буфер данных слишком мал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; После операции Get Last Btrieve удаляет всю существующую</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; позиционную информацию и устанавливает текущую позицию в индексе</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - СЛЕДУЮЩАЯ запись указывает за конец файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - ПРЕДЫДУЩАЯ запись становится предыдущим дубликатом</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; возвращаемого значения ключа или, если дубликат не</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; существует, последним дубликатом для значения ключа меньшего,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; чем возвращаемое.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; GET LESS THAN (10)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Получить меньшую чем)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Less Than ищет запись, сооответствующую значению ключа,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; которое сеньше заданного значения ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp;x &nbsp;&#166; &nbsp;x</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; x &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp;x &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Используя операцию Get Less Than Ваша прикладная программа может</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; находить запись, которая соответствует первому значению ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; меньшему чем заданное значение ключа. Btrieve поднимает путь</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; доступа, заданный номером ключа для нахождения первого значения</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ключа меньшего требуемого. Как только он найдет правильное</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; значение ключа, он возвратит соответствующую запись данных в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; буфер данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа запросит операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Less Tnan, должны быть выполнены следующие предварительные</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл не может быть файлом, состоящим только из данных без</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; заданных индексов.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Get Less Than установите следующие</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve-параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции в 10.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте блок позиции для файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохраните значение ключа в параметре буфера ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите параметр номера ключа в соответствии с правильным</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; путем доступа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте длину буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция завершилась успешно, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вернет запись в буфер данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вернет значение ключа для этой записи в буфер ключа;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Возвратит длину записи в параметре длины буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если Btrieve не может вернуть запись, он возвратит ненулевой код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статуса, указывающий на причину. Наиболее часто встречающиеся</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевые коды статуса:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;3 Файл не открыт</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;6 Неверный номер ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 22 Буфер данных слишком мал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; После операции Get Less Than Btrieve удаляет всю существующую</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; позиционную информацию и устанавливает текущую позицию в индексе</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если дубликат существует, СЛЕДУЮЩАЯ запись становится</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; первым дубликатом возвращаемого значения. Иначе, следующая</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; запись становится первой записью для значения ключа большего,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; чем возвращаемое.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если дубликат существует, ПРЕДЫДУЩАЯ запись становится</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; последним дубликатом значения ключа меньшего возвращаемого.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Иначе, предыдущая запись становится единственной записью для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; значения ключа меньшего, чем возвращаемое.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; GET LESS THAN OR EQUAL (11)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Получить меньшую или равную)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Less Than Or Equal ищет запись со значением ключа меньшим или</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; равным заданному значению ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp;x &nbsp;&#166; &nbsp;x</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; x &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp;x &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Используя операцию Get Less Than Or Equal Ваша прикладная</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; программа может находить запись, которая равна или меньше</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; заданному значению ключа. Btrieve сперва ищет в пути доступа для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; заданного значения ключа. Если он не находит значение, то</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; поднимает путь доступа, заданный номером ключа для нахождения</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; первого значения ключа меньшего требуемого. Как только он найдет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; правильное значение ключа, он возвратит соответствующую запись</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; данных в буфер данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа запросит операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Less Tnan Or Equal, должны быть выполнены следующие</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; предварительные условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл не может быть файлом, состоящим только из данных без</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; заданных индексов.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Get Less Than Or Equal установите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; следующие Btrieve-параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции в 11.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте блок позиции для файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохраните значение ключа в параметре буфера ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите параметр номера ключа в соответствии с правильным</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; путем доступа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте длину буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция завершилась успешно, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вернет запись в буфер данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вернет значение ключа для этой записи в буфер ключа;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Возвратит длину записи в параметре длины буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если Btrieve не может вернуть запись, он возвратит ненулевой код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статуса, указывающий на причину. Наиболее часто встречающиеся</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевые коды статуса:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;3 Файл не открыт</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;6 Неверный номер ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 22 Буфер данных слишком мал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; После операции Get Less Than Or Equal Btrieve удаляет всю</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; существующую позиционную информацию и устанавливает текущую</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; позицию в индексе следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если дубликат существует, СЛЕДУЮЩАЯ запись становится</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; первым дубликатом возвращаемого значения. Иначе, следующая</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; запись становится первой записью для значения ключа большего,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; чем возвращаемое.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если дубликат существует, ПРЕДЫДУЩАЯ запись становится</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; последним дубликатом значения ключа меньшего возвращаемого.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Иначе, предыдущая запись становится единственной записью для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; значения ключа меньшего, чем возвращаемое.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; GET NEXT (6)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Получить следующую)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Next ищет запись из Btrieve-файла, следующую за текущей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; записью в пути ключей.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp;x &nbsp;&#166; &nbsp;x</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; x &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp;x &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Используя операцию Get Next Ваша прикладная программа может</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; находить записи в порядке согласно заданному пути доступа. Только</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операции Get First, Get Next, Get Previous и Get Last позволяют</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; прикладной программе искать записи для значений ключей-дубликатов</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа запросит операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Next, должны быть выполнены следующие предварительные условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл не может быть файлом, состоящим только из данных без</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; заданных индексов.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Ваша прикладная программа должна установить позицию в индексе</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; при Btrieve-вызове немедленно перед операцией Get Next.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Get Next установите следующие Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции в 6.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте блок позиции для файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохраните значение ключа из предыдущей операции в буфере</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ключа. Передайте буфер ключа ТОЧНО соответствующее</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; возвращаемому Btrieve при предыдущем вызове, т.к. Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; может понадобиться предварительно сохраненная там информация</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; для определения текущей позиции в файле.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите параметр номера ключа в соответствии с путем</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; доступа, используемым при предыдущем обращении. Вы не можете</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; изменять пути доступа, используя операцию Get Next.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте длину буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция завершилась успешно, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вернет запись в буфер данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вернет значение ключа для этой записи в буфер ключа;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Возвратит длину записи в параметре длины буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если Btrieve не может вернуть запись, он возвратит ненулевой код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статуса, указывающий на причину. Наиболее часто встречающиеся</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевые коды статуса:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;3 Файл не открыт</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;6 Неверный номер ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;7 Другой номер ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;9 Конец файла</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 22 Буфер данных слишком мал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 82 Потеря позиции</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve использует позиционирование, установленное предыдущим</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; вызовом, для выполнения операции Get Next, заменяя позиционную</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; информацию следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если дубликат существует, СЛЕДУЮЩАЯ запись становится</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; первым дубликатом возвращаемого значения. Иначе, следующая</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; запись становится первой записью для значения ключа большего,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; чем возвращаемое.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если дубликат существует, ПРЕДЫДУЩАЯ запись становится</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; последним дубликатом значения ключа меньшего возвращаемого.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Иначе, предыдущая запись становится единственной записью для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; значения ключа меньшего, чем возвращаемое.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; GET POSITION (22)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Получить позицию)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Position возвращает физическую позицию текущей записи.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;x &nbsp; &nbsp; &#166; &nbsp; x &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Используя операцию Get Position Ваша прикладная программа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; может получить 4-байтовую позицию текущей записи в Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файле. Для того, чтобы установить текущую запись Ваша прикладная</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; программа может выполнить любую другую Get операцию, операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Insert или операцию Update. Ваша прикладная программа может</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; затем запросить операцию Get Position для поиска адреса записи.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Как только Ваша прикладная программа узнает адрес записи, она</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; может использовать операцию Get Direct для поиска этой записи</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; непосредственно по физическому расположению в файле.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve не выполняет какой либо ввод/вывод на диск при запросе</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Direct.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа запрсит операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Position, должны быть выполнены следующие предварительные</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Btrieve-обращение к файлу непосредственно до вызова Get</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Position должно найти запись. Вы не можете запросить вызов,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; используя тот же самый блок позиции, между поиском записи и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; вызовом Get Position.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Get Position установите следующие</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrueve-параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции равный 22.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте блок позиции для файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Используйте буфер данных достаточно длинный для хранения</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 4-байтовой позиции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите длину буфера данных равную по крайней мере</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; четырем байтам.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Get завершилась успешно, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Возвратит позицию запсии в буфер данных. Позиция - 4-байтовое</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; двоичное значение (самое важное первое слово), показывающее</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; точку входа записи (в байтах) в файле.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установит длину буфера данных равную четырем байтам.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если Btrieve не может определить текущую запись или не может</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; возвратить позицию, он вернет ненулевой код статуса указывающий</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; на причину. Наиболее часто встречающийся ненулевой статус,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; возвращаемый Btrieve, - код статуса 8 (Неверное</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; позиционирование).</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Get Position не оказывает эффект на позиционирование.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; GET PREVIOUS (7)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Получить предыдующую)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Previous ищет запись, предшествующую текущей записи в пути</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ключей.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp;x &nbsp;&#166; &nbsp;x</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; x &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp;x &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Используя операцию Get Previous Ваша прикладная программа может</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; находить записи в порядке согласно заданному пути доступа. Только</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операции Get First, Get Next, Get Previous и Get Last позволяют</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; прикладной программе искать записи для значений ключей-дубликатов</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа запросит операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get Previous, должны быть выполнены следующие предварительные</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Btrieve-обращение к файлу непосредственно до вызова Get</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Previous должно найти запись. Вы не можете запросить вызов,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; используя тот же самый блок позиции, между поиском записи и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; вызовом Get Previous.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Get Previous установите следующие</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve-параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции в 7.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте блок позиции для файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте правильный номер ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте длину буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте буфер ключа точно соответствующий возвращаемому</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Btrieve при предыдущем вызове, т.к. Btrieve может</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; понадобиться предварительно сохраненная там информация</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; для определения текущей позиции в файле.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция завершилась успешно, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Заменит буфер ключа значением ключа для новой записи;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Возвратит предыдущую запись в буфер данных;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Возвратит длину записи в параметре длины буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция не была успешной, Btrieve возвратит ненулевой код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статуса, указывающий на причину. Наиболее часто встречающиеся</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевые коды статуса:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;3 Файл не открыт</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;9 Конец файла</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 22 Буфер данных слишком мал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve использует позиционирование, установленное предыдущим</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; вызовом, для выполнения операции Get Previous следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Запись, которая была текущей при инициации вызова, становится</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; СЛЕДУЮЩЕЙ записью.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если дубликат существует, ПРЕДЫДУЩАЯ запись становится</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; последним дубликатом значения ключа меньшего возвращаемого.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Иначе, предыдущая запись становится единственной записью для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; значения ключа меньшего, чем возвращаемое.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; INSERT (4)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Добавить)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Insert добавляет запись в файл.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;x &nbsp; &nbsp; &#166; &nbsp;x &nbsp; &#166; &nbsp; &nbsp; &#166; &nbsp;x</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp;x &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ваша прикладная программа может использовать операцию Insert для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; добавления новой записи в файл. Btrieve обновляет все индексы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ключей для отражения значений ключей новой записи во время</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; добавления записи.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа запрсит операцию Insert,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; должны быть выполнены следующие предварительные условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл данных должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Добавляемая запись должна быть соответствующей длины и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; значения ключей должны соответствовать ключам, определенным</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; для файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Insert установите следующие Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте код операции равный 2.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохраните новую запись данных в буфере данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте длину буфера данных. Это значение должно быть по</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; крайней мере равно длине фиксированной части записи.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте номер ключа, для которого Вы хотите, чтобы Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; сохранял позицию.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Insert завершилась успешно, Btrieve:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Поместит новую запись в файл;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Обновит всю индексную информацию, чтобы отразить добавление</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; новой записи;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Возвратит значение ключа для текущего пути доступа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Insert не была успешной , Btrieve возвратит</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевой код статуса. Наиболее часто встречающие ошибки:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;2 ошибка ввода/вывода</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;3 Файл не открыт</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;5 Ошибка дубликатов</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 14 Ошибка открытия прообраза</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 15 Ошика ввода/вывода прообраза</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 18 Диск полный</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 21 Буфер ключа слишком мал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 22 Буфер данных слишком мал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Insert удаляет всю существующую позиционную информацию.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Опираясь на заданный Вами номер ключа Btrieve устанавливает свою</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; позицию в индексе следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Первая запись данных со значением ключа большим только что</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; добавленного становится СЛЕДУЮЩЕЙ записью.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Последняя запись данных со значением ключа меньшим только что</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; добавленного становится ПРЕДЫДУЩЕЙ записью.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; LOCKS</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Блокировки)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Блокировки позволяют Вам управлять доступом к записям и файлам,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; предохраняя рабочую станцию от выполнения конфликтных операций</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; над базой данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П &nbsp;а р а м е т р ы &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; За исключением кода операции параметры для блокировок - те же</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; самые как и в соответствующей операции записи.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve различает два различных вида блокировок записей:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; единичные блокировки и множественные блокировки. Вы можете</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; задать вид блокировки с ожиданием или без ожидания как для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; единичных блокировок, так и для множественных блокировок записей.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете задать блокировку с любой операцией &nbsp;Get, Stop, Open</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; или Begin Transaction. Добавляя смещение блокировки к операции</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Begin Transaction задавайте, хотите ли Вы транзакцию с ожиданием</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; или без ожидания. Это не приведет Btrieve к использованию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; блокировок записей в течении транзакции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ЕДИНИЧНЫЕ БЛОКИРОВКИ ЗАПИСЕЙ. Когда рабочая станция использует</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; единичные блокировки записей, она может звблокировать только одну</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; запись в файле в какой-либо момент времени. Btrieve отменяет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; единичную блокировку записи, когда Btrieve запрашивает другую</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get операцию с блокировкой для того же самого файла, корректирует</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; или удалеет заблокированную запись, или запрашивает операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Unlock.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; МНОЖЕСТВЕННЫЕ БЛОКИРОВКИ ЗАПИСЕЙ. Множественные блокировки</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; записей позволяют прикладной программе блокировать множественные</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; записи в файле и затем корректировать или удалять эти записи по</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; необходимости. Когда Вы используете множественные блокировки</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; записей, Btrieve также блокирует только одну запись для каждой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Get операции. Однако, он НЕ отменяет блокировку записи, когда Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; корректируете заблокированную запись или запрашивает другую Get</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операцию с множественной блокировкой. Ваша прикладная программа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; может отменить одну или все множественные блокировки записей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; используя операцию Unlock.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; БЛОКИРОВКИ С ОЖИДАНИЕМ. Если другая рабочая станция имеет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; заблокированную запись или имеет прерванную транзакцию для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файла, когда Вы запрашиваете блокировку с опцией ожидания,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve будет ждать до тех пор, пока запись не станет доступной,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; до того, как вернуть управление в прикладную программу.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; БЛОКИРОВКИ БЕЗ ОЖИДАНИЯ. Если другая рабочая станция имеет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; заблокированную запись или имеет прерванную транзакцию для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файла, когда Вы запрашиваете блокировку с опцией без ожидания,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve немедленно возвратит статус 84 или 85 в прикладную</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; программу, показывающий что запись - занята.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; За исключением кода операции требуемые для операции блокировки</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры идентичны требуемымв соответствующей операцией без</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; блокировки.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для задания блокировки записи Ваша прикладная программа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; прибавляет значение (называемое "смещение блокировки") к любому</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; коду операции Get, Step,, Open или Begin Transaction. Следующая</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; таблица иллюстрирует значения смещений блокировки:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Значение &nbsp; &nbsp;Тип блокировки</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+100 &nbsp; &nbsp; &nbsp;единичная блокировка записи с ожиданием</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+200 &nbsp; &nbsp; &nbsp;единичная блокировка записи без ожидания</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+300 &nbsp; &nbsp; &nbsp;множественная блокировка записи с ожиданием</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;+400 &nbsp; &nbsp; &nbsp;множественная блокировка записи без ожидания</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Используйте значения смещений блокировки следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - ДЛЯ ЗАДАНИЯ ЕДИНИЧНОЙ БЛОКИРОВКИ ЗАПИСИ прибавьте 100</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (с ожиданием) или 200 (без ожидания) к коду операции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - ДЛЯ ЗАДАНИЯ МНОЖЕСТВЕННОЙ БЛОКИРОВКИ ЗАПИСИ прибавьте 300</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (с ожиданием) или 400 (без ожидания) к коду операции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Например, для запроса Get Equal с единичной блокировкой записи с</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ожиданием код операции будет (100 + 5) или 105. Для той же самой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операции со множественной блокировкой записи с ожиданием код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операции будет (300 + 5) или 305. Для запроса Get Last с</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; единичной блокировкой записи без ожидания код операции будет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (13 + 200) или 213. Для той же самой операции со множественной</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; блокировкой записи без ожидания код операции будет (13 + 400) или</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; 413.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для задания транзакции с ожиданием установите код операции в 119</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; или 319. В этом случае код блокировки задает, что Вы хотите,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; чтобы Btrieve ждал &nbsp;файл или запись, если они заняты другой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; рабочей станцией. Задание 319 для операции Begin Transaction -</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; эквивалентно заданию или 19 или 119. См. описание управления</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; транзакциями в Главе 2 для дополнительной информации.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете также запросить Begin transaction без ожидания с кодом</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операции 219 или 419. В этом случае Btrieve возвратит статус 84</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; или 85, если Ваша прикладная программа попытается получить доступ</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; к заблокированной записи или файлу с транзакцией. См. описание &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;выполнения операции Get Key установите Btrieve-параметры так</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; управления транзакциями в Главе 2 для дополнительной информации.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ОТКРЫТИЕ ЗАБЛОКИРОВАННЫХ ФАЙЛОВ. Если файл - заблокирован, когда</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; рабочая станция пытается его открыть, Btrieve обычно ждет пока</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файл не станет доступен до выполнения операции Open. Это</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; эквивалентно блокировке с ожиданием.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы можете задать запрос открытия без ожидания, посылая или 200</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; или 400 как код операции для операции Open (0 + 200 или 0 + 400)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если файл, который Вы пытаетесь открыть, заблокирован, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; возвратит код статуса 85 (Файл занят) в прикладную прграмму. Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; можете попытаться затем повторить операцию, пока файл не станет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; доступен.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ОТМЕНА МНОЖЕСТВЕННЫХ БЛОКИРОВОК ЗАПИСЕЙ. Как упоминалось раньше,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve не отменяет автоматически множественную блокировку, как</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; он делает в случае единичной блокировки. Записи, которые Вы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; блокируете множественной блокировкой записи, остаются</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; заблокированы, пока Вы не сделаете следующее:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Отмените блокировку запросив Btrieve-операцию Unlock (27).</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Удалите запись.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Запросите Btrieve-операцию Reset (28).</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Закроете файл.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Получите доступ к файлу с транзакцией.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы не можете смешивать единичные и множественные блокировки в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; одном и том же файле с одной рабочей станции. Если единичная</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; блокировка записи (+100/+200) не отменена, когда рабочая станция</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; посылает запрос со множественной блокировкой (+300/+400), Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; возвратит ошибку несовместимости блокировок. Обратная ситуация</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; приведет к той же самой ошиббке. В обоих случаях Btrieve не</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; заблокирует запись. Это не значит, что рабочая станция ограничена</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; только одним типом блокировки для файла. Btrieve будет возвращать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ошибку, если только один тип блокировки ИСПОЛЬЗУЕТСЯ В НАСТОЯЩЕЕ</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ВРЕМЯ, когда рабочая станция пытается использовать блокировку</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; другого типа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если рабочая станция пытается разблокировать множественную</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; блокировку записи, когда она не установлена в позицию этой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; записи, Btrieve возвратит статус ошибки блокировки.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вдобавок, Btrieve возвратит статус ошибки блокировки, если Ваша</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; прикладная программа попытается заблокировать больше записей, чем</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вы задали при конфигурации BSERVER. См. описание опций</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; инициализации NetWare Btrieve в Главе 3 для дополнительной</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; информации.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Наиболее часто встречающиеся ненулевые коды статуса, возвращаемые</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve из безуспешных операций блокировки:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 81 Ошибка блокировки</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 84 Запись занята</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 85 Файл занят</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 93 Несовместимый тип бблокировки</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операции запрета не оказывают действия на позицию Btrieve в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; индексе.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; OPEN (0)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Открыть)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Open делает файл доступным.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp;x &nbsp; &nbsp; &#166; &nbsp;x &nbsp; &#166; &nbsp;x &nbsp;&#166; &nbsp;x</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ваша задача не может получить доступ к Btrieve-файлу до тех пор,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; пока она сперва не выполнит операцию Open. Файл не должен</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; находиться в текущей директории, пока вы задаете полное имя пути.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа запросит операцию Open,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; должны быть выполнены следующие предварительные условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл, который должен быть открыт, должен существовать на</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; доступном устройстве. Если файл имеет расширение, оба</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; устройства хранения, на которых расположен файл, должны быть</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; доступны.</p>
<p>  * Управление файла должно быть доступно для файла.</p>
<p>П р о ц е д у р а :</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Open установите следующие Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции в 0.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Поместите имя файла, который хотите открыть, в параметр</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ббуфера ключа. Завершите имя файла пробелом или двоичным</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; нулем. Если файла нет в текущей директории, задайте имя</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; устройства и имя пути для файла, включающее уровни директорий.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если файл имеет владельца, задайте имя владельца, завершенное</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; двоичным 0, в ббуфере данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте длину имени владельца, включая двоичный 0, в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; параметре длины буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте один из следующих режимов спецификаций в параметре</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; номера ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Режим &nbsp; &nbsp;Описание</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;-1 &nbsp; &nbsp; &nbsp;Ускоренный</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;В ускоренном режиме Ваша прикладная программа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;может заблокировать способность автоматического</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;восстановления данных для того, чтобы увеличит</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;возможность корректировки. См. "Ускоренный доступ"</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;для более подробного описания этой опции. Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;блокирует буфер в кэш-памяти для всех файлов,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;открытых в режиме ускорения. Число файл, которые</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Вы можете открыть одновременно в ускоренном</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;режиме, зависит от опций памяти и размера</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;страницы, заданных Вами при загрузке Btrieve.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;-2 &nbsp; &nbsp; &nbsp;Только чтение</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Этот режим позволяет Вашей прикладной программе</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;открыть поврежденный файл, который Btrieve не</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;может автоматически восстановить. Когда Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;открывает файл в режиме "только чтение", Ваша</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;прикладная программа может только читать файл; она</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;не может выполнять корректировки. Если были</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;повреждены индексы файла, записи можно найти</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;открывая файл в режиме "только чтение" и затем</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;используя операцию Step Next.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;-3 &nbsp; &nbsp; &nbsp;Верификация</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Режим верификации применим только к файлам,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;расположенным на локальных DOS-дисках. Если Ваша</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;прикладная программа открывает локальный файл в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;режиме верификации, Btrieve имеет опцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;верификации DOS во время каждой операции. После</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;каждой записи на диск операционная система</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;перечитывает данные, чтобы удостовериться в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;правильности их записи. Хотя ошибки записи на</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;диск очень редки, Btrieve обеспечивает эту функцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;на случай, если Вы хотите прверить правильность</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;записи критических данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; -4 &nbsp; &nbsp; Исключительный</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Исключительный режим дает рабочей станции</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;исключительный доступ к файлу на разделяемом</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;устройстве. Никакая другая рабочая станция не</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;может открыть этот файл до тех пор, пока рабочая</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;станция, имеющая исключительный доступ к файлу,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;не закроет его. Исключительный режим имеет место</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;только для файлов, расположенных на разделяемом</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;устройстве. Если Вы запросите исключительный режим</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;для файла на локальном диске, Btrieve откроет файл</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;в обычном режиме.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Другие &nbsp;Нормальный</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для доступа к Bteieve-файлу из Бейсика необходимы два шага.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Во-первых, Ваша прикладная программа должна запросить операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; BASIC OPEN для устройства NUL для того, чтобы использовать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; утверждение FIELD для буфера данных файла. (См. "Вызов Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; из BASIC" для дополнительной информации). Во-вторых, прикладная</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; программа должна выполнить Btrieve-операцию Open. другие языки не</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; требуют первого шага.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve допускает до 255 открытых файлов для BASIC-компилятора,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Pascal, COBOL или C прикладных задач. Когда множественные файлы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; открыты в одно и то же время, Btrieve использует блок текущей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; позиции для определения, к какому файлу нужен доступ при данном</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; вызове.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;---------------------------------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ПРИМЕЧАНИЕ:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Хотя Btrieve позволяет прикладной программе открывать до</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;255 файлов, BASIC-интерпретатор и некоторые компиляторы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;BASIC-а позволяют максимально только 15 открытых файлов.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Для доступа к более, чем трем файлам, BASIC требует, чтобы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Вы задали параметр файлов / при инициации BASIC-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;интерпретатора. Когда Вы открываете множественные файлы в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;одно и то же время из BASIC-а, Btrieve использует FCB для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;определения, к какому файлу нужен доступ при данном</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;вызове. См. документацию по BASIC-интерпретатору или</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;компилятору для дополнительной информации.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;---------------------------------------------------------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Opene завершилась успешно, Btrieve:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Назначьте обработчик файла для файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Зарезервируйте блок позиции, передаваемый при вызове Open для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; вновь открываемогофайла;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сделайте файл доступным.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Open завершилась ошибочно, Btrieve возвратит</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевой код статуса. Наиболее распростанееные ненулевые коды</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статуса для операции Open:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;2 Ошибка ввода/вывода</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 46 Путь доступа к файлу неверен</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 85 Файл занят</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 86 Таблица файла заполнена</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 87 Таблица обработки заполнена</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Open не устанавливает какую-либо позиционную информацию.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; RESET (28)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Сброс)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Reset освобождает все ресурсы, захваченные рабочей станцией,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; такие как оставшиеся блокировки при ошибочном завершении</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; прикладной программы.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp;x &nbsp;&#166; &nbsp;x</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ваша прикладная программа может выполнять операцию Reset для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; освобождения всех ресурсов, захваченных рабочей станцией в сети.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Эта операция отменяет все транзакции рабочей станции, отменяет все</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; блокировки и закрывает открытые файлы рабочей станции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ваша прикладная программа может запрсить операцию Reset в любое</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; время после загрузки Record Manager.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Reset установите следующие Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции равный 28.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите парвметр номера ключа в -1, если Ваша прикладная</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; программа освобождает ресурсы для другой рабочей станции</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; сети.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохраните номер связи рабочей станции, на которой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; осуществляется сброс, как целое число в первых 2 байтах</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; буфера ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Reset завершилась успешно, Btrieve:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Закроет все открытые файлы для заданной рабочей станции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Отменит все блокировки, заданные данной рабочей станцией.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Отменит все активные транзакции на данной рабочей станции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция не была успешной &nbsp;по какой-либо причине, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; возвратит ненулевой код статуса.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Reset разрушает всю позиционную информацию, т.к.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; закрывает все открытые файлы.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; SET DIRECTORY (17)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Установить директорию)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Set Directory устанавливает текущую директорию в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; заданное значение.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp;x &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Set Directory изменяет текущую директорию на директорию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; заданную в параметре буфера ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа запрсит операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Set Directory, устройство-приемник и директория должны стать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; доступны.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для установки текущей директории установите следующие Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции равный 17.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохраните требуемое устройство и путь директории, завершенные</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; двоичным 0, в буфере ключа. Если Вы опустите имя устройства,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Btrieve будет использовать устройство, заданное по умолчанию.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Если Вы не задатите полный путь для директории, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; добавит путь директории, заданный в буфере ключа, к текущей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; директории.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Set Directory завершилась успешно, Btrieve сделает</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; директорию, заданную в буфере ключа, текущей директорией.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция не была успешной, Btrieve оставит текущую</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; директорию неизмененной и возвратит ненулевой статус.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Set Directory не оказывает эффект на позиционирование.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; SET OWNER (29)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Установить владельца)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Set Owner присваивает имя владельца файлу.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; x &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp;x &nbsp;&#166; &nbsp;x</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Set Owner присваивает имя владельца файлу таким образом</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; что пользователи, не знающие это имя, не могут получить доступ к</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файлу. Если для файла было установлено имя владельца,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; пользователи или прикладные программы должны задавть имя</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; владельца всякий раз, как они пытаются открыть файл. Вы можете</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; задать, чтобы имя владельца требовалось при любом доступе или</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; только при корректировке.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Когда Вы присвоите имя владельца файлу, Вы можете также указать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve зашифровать данные файла на диске. Если Вы задаете</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; шифровку данных, Btrieve зашифрует все данные во время операции</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Set Owner. Чем длиннее файл, тем дольше выполняется Set Owner&amp;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа запрсит операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Set Owner, должны быть выполнены следующие предварительные</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Не должно быть активных транзакций.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Имя владельца не должно уже быть присвоено файлу.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Set Owner установите следующие Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции равный 29.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте блок позиции, определяющий файл, что Вы хотите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; защитить.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохраните имя владельца в буфере данных и в буфере ключа и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; передайте длину буфера данных. Bteieve требует имя в обоих</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; буферах, чтобы избежать возможность случайного задания</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; неправильного значения. Имя владельца может быть длиной до</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; восьми символов и должно завершаться двоичным 0.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите параметр номера ключа в целое число, задающее тип</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ограничений доступа, которые Вы хотите задать для файла, и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; должны ли быть данные зашифрованы. В Таблице 6.2 перечислены</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; значения, задаваемые Вами для номера ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Значение &nbsp; Описание</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 0 &nbsp; &nbsp; &nbsp;Запросы имени владельца при любом методе</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;доступа (нет шифровки данных)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 1 &nbsp; &nbsp; &nbsp;Предоставление доступа "только чтение" без</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;имени владельца (нет шифровки данных)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2 &nbsp; &nbsp; &nbsp;Запросы имени владельца при любом методе</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;доступа (с шифровкой данных)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 3 &nbsp; &nbsp; &nbsp;Предоставление доступа "только чтение" без</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;имени владельца (с шифровкой данных)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Таблица 6.2</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Коды имени владельца и шифровки данных</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Set Owner завершилась успешно, Btrieve:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Не позволит получить доступ к файлу, пока не будет задано имя</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; владельца;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Зашифрует данные в файле, если задана шифровка.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Как только Ваша прикладная программа установит имя владельца, оно</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; останется действительным до тех пор, пока Ваша прикладная</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; программа не запросит операцию Clear Owner.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Set Owner не была успешной, Btrieve возвратит</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевой статус. Наиболее часто встречающиеся ненулевые коды</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статуса:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 41 Недопустимая операция</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 50 Владелец уже установлен</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 51 Неправильное имя владельца</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Set Owner не оказывает эффект на позиционирование.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; STAT (15)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Статистика)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Stat ищет характеристики для заданного файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; x &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp;x &nbsp; &nbsp; &#166; &nbsp; x &nbsp;&#166; &nbsp;x &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp;x &nbsp; &nbsp; &#166; &nbsp; x &nbsp;&#166; &nbsp;x &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Используя операцию Stat Ваша прикладная программа может</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; определять характеристики, заданные для файла при его создании.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Вдобавок операция Stat возвращает число записей в файле, число</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; уникальных значений ключей, храниых для каждого индекса в файле,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; число неиспользуемых страниц в файле и все дополнительные индексы</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; определенные для файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve возвращает характеристики файла в буфер данных в том же</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; самом двоичном формате как и в операции Create. Для 4-байтовых</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; переменных (число ключей и записей) Btrieve возвращает младшую</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; часть числа в первых 2 байтах, за которыми следует старшая часть</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; числа в последних 2 байтах. Зарезервированные области также</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; размещаются, хотя Btrieve игнорирует их в операции Stat.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Флаги файла появляются как показано ниже:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 0 = 1, файл допускает записи переменной длины.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 1 = 1, Btrieve усечет пробельные концы в записях</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; переменной длины.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 2 = 1, Btrieve перераспределит страницы для файла</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 3 = 1, Btrieve сожмет данные в файле.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 4 = 1, Btrieve создаст файл, состоящий только из</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ключей.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 6 = 1, Btrieve установит 10% границу свободного</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; пространства.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 7 = 1, Btrieve установит 20% границу свободного</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; пространства.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 6 = 1 и бит 7 = 1, Btrieve установит 30% границу</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; свободного пространства.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Спецификации ключа появляются непосредственно за спецификациями</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файла и повторяются для каждого сегмента в файле. Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; устанавливает флаги ключа следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 0 = 1, ключ допускает дубликаты.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 1 = 1, ключ - модифицируемый.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 2 = 0 и бит 8 = 0, ключ - строковый.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 2 = 1 и бит 8 = 0, ключ - двоичный.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 3 = 1, ключ имеет пустое значение.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 4 = 1, ключ имеет другой сегмент.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 5 = 1, ключ отсортирован с помощью последовательности</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; альтернативного поиска.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 6 = 1, ключ отсортирован в убывающем порядке.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Бит 7 игнорируется для операции Create.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 8 = 0, ключ - стандартного типа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 8 = 1, ключ - расширенного типа,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Если бит 9 = 1, ключ - ручной.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; См. операцию Create в этой главе, где находится таблица</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; иллюстрирующая десятичные значения этих флагов.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если Вы задаете альтернативную последовательность поиска</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; для любого из ключей или ключевых сегментов файла, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; возвратит определение последовательности непосредственно за</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; блоком спецификаций последненго ключа. Btrieve возвратит буфер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; данных в формате, показанном в Таблице 6.3.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; Описание &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;Длина&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; +-----------------------+-----+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; длина записи &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp;2 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; размер страницы &nbsp; &nbsp; &nbsp; &#166; &nbsp;2 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;спецификации &nbsp; &#166; кол-во индексов &nbsp; &nbsp; &nbsp; &#166; &nbsp;2 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; файла &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; кол-во заисей &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp;4 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; флаги файла &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp;2 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; резервное слово &nbsp; &nbsp; &nbsp; &#166; &nbsp;2 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;неиспользуемые страницы&#166; &nbsp;2 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; L-----------------------+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; Описание &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;Длина&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; +-----------------------+-----+</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; позиция ключа &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp;2 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; длина ключа &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp;2 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;спецификации &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ключей &nbsp; &nbsp; &nbsp; &#166; флаги ключа &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp;2 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(повторяются) &nbsp;&#166; кол-во ключей &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp;4 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; тип расширенного ключа&#166; &nbsp;1 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; пустое значение &nbsp; &nbsp; &nbsp; &#166; &nbsp;1 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;-----------------------&#166;-----&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; зарезервировано &nbsp; &nbsp; &nbsp; &#166; &nbsp;4 &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; L-----------------------+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Таблица 6.3</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Буфера данных для операции Stat</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До выполненият операции Stat Ваша прикладная программа должна</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; сперва открыть Btrieve-файл.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Stat установите следующие Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции в 15.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте блок позиции файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Покажите буфер данных (для хранения статистики по файлу и</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ключам) и альтернативную последовательность поиска, если она</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; задана.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте длину буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Покажите буфер ключа длиной по крайней мере 64 символа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Stat завершилась успешно, Btrieve:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Возвратит характеристики файла и ключей в буфер данных;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Сохранит имя расширения файла, завершенное двоичным нулем, в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;буфер ключа, если Вы до этого расширили файл. Иначе, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;проинициализирует первый байт буфера ключа нулем.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция завершилась безуспешно, Btrieve вернет ненулевой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; код статуса, информирующий о причине. Наиболее часто встречающие</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевые коды:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;3 Файл не открыт</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 22 Буфер данных слишком мал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Stat Create не устанавливает какую-либо позиционную</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; информацию.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; STEP FIRST (33)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Шаг на первую)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Step First ищет запись, размещенную физически первой в файле.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; x &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Step First позволяет Вашей прикладной программе искать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; запись, размещенную физически первой в файле. Btrieve не</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; использует индексный путь для поиска записи.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа сможет выполнить операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Step First, файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Step First установите следующие Btrueve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте код операции равный 33.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте блок позиции для файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Покажите буфер данных, в котором хранится возвращаемая запись</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите параметр длины буфера данных равный длине буфера</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция завершилась успешно, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вернет физически первую запись файла в буфер данных Вашей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; прикладной программы.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установит параметр длины буфера данных равный количеству</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; байтов в возвращаемой записи.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция &nbsp;не была успешной, Btrieve вернет ненулевой код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статуса указывающий на причину. Наиболее часто встречающиеся</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевые коды статуса:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;3 Файл не открыт</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;9 Конец файла</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 22 Буфер данных слишком мал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Step First не устанавливает позицию в индексе.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; STEP LAST (33)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Шаг на последнюю)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Step Last ищет запись, размещенную физически последней в файле.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; x &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Step Last позволяет Вашей прикладной программе искать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; запись, размещенную физически последней в файле. Btrieve не</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; использует индексный путь для поиска записи при операции</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Step Last.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа сможет выполнить операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Step Last, файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Step Last установите следующие Btrueve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте код операции равный 34.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте блок позиции для файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Покажите буфер данных, в котором хранится возвращаемая запись</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите параметр длины буфера данных равный длине буфера</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция завершилась успешно, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вернет физически последнюю запись файла в буфер данных;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установит параметр длины буфера данных равный количеству</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; байтов в возвращаемой записи.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция &nbsp;не была успешной, Btrieve вернет ненулевой код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статуса указывающий на причину. Наиболее часто встречающиеся</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевые коды статуса:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;3 Файл не открыт</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;9 Конец файла</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 22 Буфер данных слишком мал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Step Last не устанавливает позицию в индексе.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; STEP NEXT (24)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Шаг на следующую)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Step Next ищет запись, физически следующую за текущей записью.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; x &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Step Next позволяет Вашей прикладной программе искать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; записи в том порядке, в котором они физически хранятся. Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; не использует индексный путь для поиска записи при операции</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Step Next. Операция Step Next, запрашиваемая непосредственно после</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операции Open, возвращает первую запись в файле. Операция</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Step Next, запрашиваемая непосредственно после любой операции Get</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; или Step, возвращает запись, физически следующую за записью,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; найденной предыдущей операцией.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ваша прикладная программа не может прогнозировать порядок, в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; котором записи будут возвращаться операцией Step Next.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа сможет выполнить операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Step Next, файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Step Next установите следующие Btrueve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте код операции равный 24.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте блок позиции для файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Покажите буфер данных, в котором хранится возвращаемая запись</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте длину буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция завершилась успешно, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вернет физически последнюю запись файла в буфер данных Вашей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; прикладной программы;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установит параметр длины буфера данных равный количеству</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; байтов в возвращаемой записи.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция &nbsp;не была успешной, Btrieve вернет ненулевой код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статуса указывающий на причину. Наиболее часто встречающиеся</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевые коды статуса:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;3 Файл не открыт</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;9 Конец файла</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 22 Буфер данных слишком мал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Step Next не устанавливает позицию в индексе.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; STEP PREVIOUS (36)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Шаг на предыдующую)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Step Previous позволяет Вашей прикладной программе искать запись</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; физически предшествующую текущей записи.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; x &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Step Previous позволяет Вашей прикладной программе искать</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; записи в том порядке, в котором они физически хранятся. Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; не использует индексный путь для поиска записи при операции</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Step Previous. Операция Step Previous, запрашиваемая</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; непосредственно после любой операции Get или Step, возвращает</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; запись, физически предшествующую записи, найденной предыдущей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; операцией.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная программа сможет выполнить операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Step previous, должен быть выполнены следующие предварительные</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Предыдущей операцией должна быть успешно выполненная операция</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Get или Step.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Step Previous установите следующие Btrueve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте код операции равный 35.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте блок позиции для файла.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Покажите буфер данных, в котором хранится возвращаемая запись</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Задайте длину буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция завершилась успешно, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Вернет физически последнюю запись файла в буфер данных Вашей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; прикладной программы;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установит параметр длины буфера данных равный количеству</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; байтов в возвращаемой записи.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция &nbsp;не была успешной, Btrieve вернет ненулевой код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статуса указывающий на причину. Наиболее часто встречающиеся</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; ненулевые коды статуса:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;3 Файл не открыт</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;9 Конец файла</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 22 Буфер данных слишком мал</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Step Previous не устанавливает позицию в индексе.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; STOP (25)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Остановить)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Stop завершает программу BREQUEST и удаляет ее из</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; памяти рабочей станции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Stop удаляет программу запросов (BREQUEST) из памяти рабочей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; станции. Btrieve прикладная программа на рабочей станции не</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; может выполнять какие-либо другие Btrieve- операции до тех пор,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; пока вы не стартуете вновь BREQUEST.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Stop удаляеттолько из памяти рабочей станции, где</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; выполняется Btrieve-запрос. вы не можете остановить BREQUEST на</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; другой рабочей станции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; BREQUEST должен быть загружен до того, как Ваша прикладная</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; программа сможет Запросить операцию Stop.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Stop Ваша прикладная программа задает</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; код операции равный 25.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Stop завершилась успешно, Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Удалит BREQUEST из памяти на рабочей станции:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Закроет все предварительно открытые файлы для раочей станции</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Снимет все активные транзакции;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Отменит все блокировки на рвбочей станции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Stop не была успешной, Btrieve вернет ненулевой код</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статуса. Наиболее часто встречающийся &nbsp;ненулевой код статуса 20</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (BREQUEST не загружен).</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Stop не устанавливает какую-либо позицию.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; UNLOCK (27)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Отмена блокировки)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Unlock отменяет блокировки одной или более записей,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; которые предварительно были заблокированы.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; x &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp; &nbsp; &#166; &nbsp;x</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Unlock полностью отменяет блокировки одной или более записей для</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; файла, связанного с заданным блоком позиции.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная &nbsp;программа сможет запросить операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Unlock на рвбочей станции, рабочая станция должна установить по</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; крайней мере блокировку одной записи.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для отмены единичной блокировки записи,установите следующие</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Btrieve-параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции равный 27.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте блок позиции файла, содержащего заблокированную</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; запись.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите номер ключа в неотрицательное значение.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для отмены множественной блокировки записи одного типа, сперва</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; найдите 4-байтовую позицию записи, которую Вы хотите</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; разблокировать, с помощью операции Get Position (22) для этой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; записи. Затем запросите операцию Unlock , устанавливая</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Btrieve-параметры следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции равный 27.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте Btrieve блок позиции файла, содержащего</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; заблокированную запись.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохраните (в буфере данных) 4-байтовую позицию, возвращаемую</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Btrieve.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите длину буфера данных равную 4.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Проинициализируйте параметр номера &nbsp;ключа -1.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для отмены всех множественных блокировок записи файла Вы должны</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; устанавить Btrieve-параметры следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции равный 27.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте Btrieve блок позиции файла, содержащего</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; множественные блокировки.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Проинициализируйте параметр номера &nbsp;ключа -2.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Unlock завершилась успешно, Btrieve отменит все</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; блокировки, задаваемые этой операцией.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Unlock не была успешной, Btrieve вернет ненулевой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статус. Наиболее часто встречающийся &nbsp;ненулевой код статуса 81</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Ошибка блокировки).</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Unlock не оказывает действие на позиционирование.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; UPDATE (3)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Корректировка)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Update корректирует существующую запись в файле.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; x &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp; &nbsp; &#166; &nbsp;x</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp;x &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp;&#166; &nbsp;x &nbsp;&#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Update изменяет информацию в существующей записи.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Ваша прикладная &nbsp;программа сможет запросить операцию</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Update, должны встретиться следующие предварительные условия:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Файл должен быть открыт.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Btrieve-обращение к файлу, выполняемое непосредственно перед</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; вызовом Update, должно найти запись6 которая будет</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; корректироваться. вы не можете запрашивать вызов, используя</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; тот же самый блок позиции, во время между поиском Вашей</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; прикладной программой записи и корректировкой записи.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Update установите следующие Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции равный 3.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Передайте блок позиции файла, содержащего эту запись.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохраните скорректированную запись в буфере данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите длину буфера данных равной длине корректируемой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; записи.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Сохраните номер ключа, используемый для поиска запис, в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; параметре номера ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Update завершилась успешно, Btrieve:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Заменит заменит запись, хранящуюся в файле, новым значением</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; из буфера данных.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Обновит индексы ключей для отражения любых изменений в</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; значениях ключей.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Заменит параметр буфера ключа, если потребуется.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Update не была успешной, Btrieve вернет ненулевой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; код статуса. Наиболее часто встречающиеся &nbsp;ненулевые коды статуса</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;5 Ошибка дубликата ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;7 Другой номер ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;8 Неправильное позиционирование.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 10 Ошибка модифицируемого ключа.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 14 Ошибка открытия прообраза.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 15 Ошибка ввода/вывода прообраза.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 22 Буфер данных слишком мал.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - 80 Ошибка конфликта.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Update изменяет позиционную информацию только когда</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; изменяется значение ключа. В этом случае Btrieve устанавливает</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; свою позицию в индексе, опираясь на заданный Вами номер ключа,</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; следующим образом:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Первая запись со значением ключа большим, чем обновленный</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ключ, становится СЛЕДУЮЩЕЙ записью.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Первая запись со значением ключа меньшим, чем обновленный</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ключ, становится ПРЕДЫДУЩЕЙ записью.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; VERSION (26)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; (Версия)</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Н а з н а ч е н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Version возвращает текущую версию Btrieve и номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; пересмотра.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р и м е н е н и е &nbsp; п а р а м е т р о в &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------T----------------------T------T-----T------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp;FCB &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166;Длина &#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Операция&#166;Блок поз.&#166;Буфер данных&#166;буфера&#166;Буфер&#166;Номер</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166;данных&#166;ключа&#166;ключа</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------+---------+------------+------+-----+------</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Ожидаемые &nbsp; &nbsp; &nbsp; x &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Возвращаемые &nbsp; &nbsp; &nbsp; &nbsp;&#166; &nbsp; &nbsp; &nbsp; &nbsp; &#166; &nbsp; &nbsp; x &nbsp; &nbsp; &nbsp;&#166; &nbsp; x &nbsp;&#166; &nbsp; &nbsp; &#166;</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; О п и с а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Эта операция возвращает текущую версию Btrieve и номер пересмотра.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р е д в а р и т е л ь н ы е &nbsp; &nbsp;у с л о в и я &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; До того, как Вы сможете запросить операцию Version, должен быть</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; загружен Btrieve Record Manager.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; П р о ц е д у р а &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Для выполнения операции Version установите следующие Btrieve-</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; параметры:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите код операции равный 26.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Посмотрите, чтобы буфер данных был по крайней мере длиной 5</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; байтов.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Установите длину буфера данных равной 5.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Р е з у л ь т а т &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Version завершилась успешно, Btrieve возвратит</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; данные в буфер данных в следующем формате:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Размер &nbsp; &nbsp; Описание</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2 &nbsp; &nbsp; &nbsp; Целое число, содержащее номер версии</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2 &nbsp; &nbsp; &nbsp; Целое число, содержащее номер пересмотра</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1 &nbsp; &nbsp; &nbsp; Символ, содержащий "N" для NetWare Btrieve</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Если операция Version не была успешной, Btrieve вернет ненулевой</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; статус.</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Т е к у щ е е &nbsp; п о з и ц и о н и р о в а н и е &nbsp;:</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; Операция Version не оказывает влияния на текущее</p>
<p>  &nbsp; &nbsp; &nbsp; &nbsp; позиционирование.</p>


