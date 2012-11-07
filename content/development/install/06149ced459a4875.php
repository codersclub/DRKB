<h1>Что делает inf-файл?</h1>
<div class="date">01.01.2007</div>


<p>Он позволяет осуществить:</p>

<p>   Создание элементов реестра</p>
<p>   Определение инициализационных параметров (INI-settings)</p>
<p>   Копирование файлов с дистрибутива и размещение их в системе</p>
<p>   Инсталляция устройств</p>
<p>   Управление другими INF-фаилами</p>
<p>   Конфигурирование опций устройств</p>

<p>INF-файлы представляют собой инициализационные файлы, которые конфигурируют</p>
<p>устройство  или приложение в вашей системе и задают его элементы в реестре.</p>
<p>INF-файлы  обычно поставляются производителем продукта вместе с устройством</p>
<p>или  приложением. Кроме того, можно их найти на электронных досках объявле-</p>
<p>ний и других on-line сервисах. INF-файлы понадобятся вам для многих обычных</p>
<p>(не  РпР)  устройств,  которые вам нужно будет конфигурировать для работы с</p>
<p>Windows  95.  Как  правило, INF-файлы включают список допустимых логических</p>
<p>конфигураций,  имена  файлов драйверов устройств и г. д. В ряде случаев вам</p>
<p>потребуется самим писать INF-файлы для устройств или программного обеспече-</p>
<p>ния. Формат lNF-файлов аналогичен формату INIфайлов, которые использовались</p>
<p>в Windows З.х, включая квадратные скобки, ключи и разделы, используемые то-</p>
<p>лько Windows 95.</p>

<p>Структура INF-файла</p>
<p>Когда  вы  инсталлируете новое устройство. Windows ищет INF-фаилы для этого</p>
<p>устройства, используя при этом идентификатор устройства (device ID). Собрав</p>
<p>из  INF-фаила всю необходимую информацию, система создает в реестре элемент</p>
<p>для  этого  устройства под ключом HKEY_LOCAL_MACHINE. Значения из INF-файла</p>
<p>копируются  в  элемент  реестра, соответствующий драйверу устройства. Такие</p>
<p>значения,  как  DevLoader=  и  Driverdesc= включаются в элемент аппаратного</p>
<p>драйвера Driver=. Элемент Еnum содержит значения Driver= и ConfigFlags=.</p>
<p>INF-фаилы представляют собой файлы в формате ASCII, состоящие из нескольких</p>
<p>разделов.  Каждый  раздел  предназначен для выполнения определенной задачи.</p>
<p>Имена  разделов  обычно  заключаются в квадратные скобки. Типичные элементы</p>
<p>представляют  собой ключ и значение, соединенные знаком равенства. В раздел</p>
<p>можно  включить  одно или несколько значений. Кроме того, в состав элемента</p>
<p>можно включать комментарии, отделяя их символом точки с запятой, например:</p>

<p>[section]</p>
<p>keyname=value ;эта часть строки является комментарием</p>

<p>Поскольку  INF-файлы  являются  файлами  формата ASCII, должен существовать</p>
<p>способ,  с  помощью  которого  они будут предоставлять реестру информацию в</p>
<p>двоичном  формате. Структура INF определяет двоичный файл, который преобра-</p>
<p>зует ASCII-текст в двоичный формат при чтении его реестром.</p>

<p>Типы информационных файлов:</p>
<p>   Layout  (Формат). Определяет информацию о диске и номере версии, а также</p>
<p>содержит  список всех файлов с указанием диска, на котором они располагают-</p>
<p>ся.</p>
<p>   Selective  Install (Избирательная инсталляция). Определяет части инстал-</p>
<p>ляции,  являющиеся необязательными компонентами, а также те ее части, кото-</p>
<p>рые зависят от инсталляции других компонентов. Например, Microsoft Fax тре-</p>
<p>бует предварительной загрузки Microsoft Exchange. Вы имеете возможность уп-</p>
<p>равлять инсталляцией компонент этих типов.</p>
<p>   Application/Installation, APPS.INF (Приложения/Инсталляция). Обнаружива-</p>
<p>ет  используемые  вами  приложения MS-DOS и устанавливает для них параметры</p>
<p>окружения. Эти lNF-файлы содержат настройки и параметры для многих приложе-</p>
<p>ний  DOS. Как правило, это самый большой информационный файл в вашей систе-</p>
<p>ме. В его состав входят многие виды настройки памяти, настройки расширенной</p>
<p>памяти (XMS), а также другие параметры, которые в Windows З.х содержались в</p>
<p>настройках PIF</p>
<p>   Device  Installation  and Configuration (Инсталляция и конфигуриро вание</p>
<p>устройств).  Это наиболее общий из всех информационных файлов на котором мы</p>
<p>до  сих пор концентрировали все внимание. Эти файлы описывают параметры на-</p>
<p>стройки для конкретных физических устройств. Если вы имеете драйвер устрой-</p>
<p>ства  ранних  версий, в INF-файле будет содержаться информация об этом уст-</p>
<p>ройстве.  Устройства Plug and Play, с другой стороны, помещают информацию о</p>
<p>себе прямо в реестр.</p>

<p>Общая организация lNF-файла</p>
<p>Раздел каждого устройства в INF-файлс состоит из следующих разделов:</p>

<p>Раздел  [Version].</p>
<p>Идентифицирует  INF и класс поддерживаемого устройства.</p>
<p>Ниже перечислен список некоторых устройств, которые вы можете включить:</p>

<p>adapter                 keyboard        NetService</p>

<p>CDROM                   MCADevices      NetTrans (сетевые транспорты)</p>
<p>diskdrive               media           nodriver</p>
<p>dispaly                 modem           PCMCIA</p>
<p>EISADevices             monitor         ports</p>
<p>Fdc                     mouse           printer</p>
<p>Hdc                     MTD             SCSIAdapter</p>

<p>Раздел [Manufacturer].</p>
<p>Идентифицирует  производителя  устройства (например, Link, Micro, и т.п.) и</p>
<p>соответствующих  продуктов.  Каждый  INF-файл  должен иметь по крайней мере</p>
<p>один раздел [ Manufacturer].</p>

<p>Раздел [Install].</p>
<p>Содержит информацию о физических атрибутах устройства и его драйверах.</p>

<p>Раздел [Classlnstall].</p>
<p>Этот раздел необязателен. Он идентифицирует новый класс для указанного уст-</p>
<p>ройства в INF-фаиле</p>

<p>Раздел [String].</p>
<p>Идентифицирует локализованные строки в INF-фаиле</p>

<p>Раздел [Miscellaneous].</p>
<p>Содержит  информацию о том, как устройства управляются пользовательским ин-</p>
<p>терфейсом W95.</p>

<p>Элементы APPS.INF</p>
<p>В  разделе  [appname]  файла  APPS.INF вы найдете элементы, перечисленные в</p>
<p>табл.  Используя  эти элементы вы сможете быстрее перенести в W95 настройки</p>
<p>PIF из ваших старых инсталляций Windows.</p>
<p>Многие  из  приложений,  перечисленных в файле APPS.INF, представляют собой</p>
<p>старые игры для MS-DOS. Если вы сталкиваетесь с тем, что игра не работает в</p>
<p>среде  W95, просмотрите этот файл. Возможно, вам удастся модифицировать ка-</p>
<p>кой-либо  из  его элементов таким образом, чтобы игра запустилась или стала</p>
<p>работать  лучше. Если вы вносите изменения в файл APPS.INF, вам потребуется</p>
<p>перезагрузить W95, чтобы внесенные изменения попали в реестр. Помимо редак-</p>
<p>тирования  файла  APPS.INF, некоторые из параметров вы можете изменить, от-</p>
<p>крыв страницу свойств конкретного приложения.</p>
<p>Ниже приведен пример раздела [аррname]:</p>

<p>[PRODIGY.EXE]</p>
<p>LowMem=440</p>
<p>EMSMen=None</p>
<p>XMSMem=None</p>
<p>Enable=lml</p>
<p>Disable=win,hma</p>

<p>В этой части файла APPS.INF раздел [appname] замещается именем исполняемого</p>
<p>модуля, например, PRODIGY.EXE, PARADOX.EXE и т.п.</p>

<p>Имя элемента реестра           Описание ключа                       Значение</p>

<p>ALLOWSSAVER              Позволяет появляться заставке              sav</p>
<p>(работает в REALMODE)    при работающих программах DOS.</p>
<p>                         Настройка по умолчанию</p>

<p>ALTENTER                 Позволяет использовать клавиатурную        аеn</p>
<p>                         комбинацию + для переклю-</p>
<p>                         чения между полноэкранным и оконным</p>
<p>                         режимами. Настройка по умолчанию.</p>

<p>ALTESC                   Позволяет использовать выход с помощью     Aes</p>
<p>                         клавиатурной комбинации -.</p>
<p>                         Настройка по умолчанию.</p>

<p>ALTPRTSCRN               Позволяет выполнять моментальный снимок    Psc</p>
<p>                         экрана с помощью клавиатурной комбинации</p>
<p>                         +. Настройка по умолчанию.</p>

<p>ALTSPACE                 Позволяет использовать клавиатурную        aps</p>
<p>                         комбинацию + для отображения</p>
<p>                         системного меню. Настройка по умолчанию.</p>

<p>ALTTAB                   Позволяет использовать клавиатурную ком-   Ata</p>
<p>                         бинацию для переключения между приложе-</p>
<p>                         ниями. Настройка по умолчанию.</p>

<p>BACKGROUND               Дает приложению указание работать в        win</p>
<p>                         фоновом режиме. Настройка по умолчанию.</p>

<p>CDROM                    Позволяет использовать драйвер MSCDEX.     cdr</p>
<p>(работает в REALMODE)    Настройка по умолчанию.</p>

<p>CLOSEONEXIT              Закрывает при выходе окно DOS. He явля-    cwe</p>
<p>                         ется настройкой по умолчанию.</p>

<p>CRTLESC                  Позволяет закрывать приложение нажатием    ces</p>
<p>                         клавиатурной комбинации +.</p>
<p>                         Настройка по умолчанию.</p>

<p>DETECTIDLE              Задает чувствительность в неактивном сос-   dit</p>
<p>                        тоянии. Настройка по умолчанию.</p>

<p>DISKLOCK                Позволяет осуществлять прямой доступ к      dsk</p>
<p>(работает в REALMODE)   диску.</p>

<p>EMS                     Активизирует EMS386 для программ DOS.       ems</p>
<p>(работает в REALMODE)   Настройка по умолчанию.</p>

<p>EMSLOCKED               Указывает на блокировку памяти EMS          eml</p>

<p>EMULATEROM              Указывает на необходимость использо-        emt</p>
<p>                        вания быстрой эмуляции ROM. Настройка</p>
<p>                        по умолчанию.</p>

<p>EXCLUSIVE               Работает в эксклюзивном режиме. Этот        exc</p>
<p>                        параметр игнорируется.</p>

<p>FASTPASTE               Активизирует быструю вставку из прило-      aft</p>
<p>                        жения. Настройка по умолчанию.</p>

<p>GLOBALMEM               Активизирует глобальную защиту памяти       gmp</p>

<p>LOWLOCKED               Указывает на то, что нижняя память          lml</p>
<p>                        (до 640 Кб) заблокирована. Этот параметр</p>
<p>                        игнорируется.</p>

<p>MOUSE                   Активизирует функции мыши. Настройка по     mse</p>
<p>(работает в REALMODE)   умолчанию.</p>

<p>NETWORK                 Разрешает программе DOS получать доступ     net</p>
<p>(работает в REALMODE)   к сетевым дискам и принтерам. Настройка</p>
<p>                        по умолчанию.</p>

<p>PRIVATECFG              Позволяет программе DOS использовать пер-   cfg</p>
<p>(работает в REALMODE)   сональный файл CONFIG.SYS. He является</p>
<p>                        настройкой по умолчанию.</p>

<p>REALMODE                Запускает программу в реальном режиме DOS.  dos</p>
<p>                        He является настройкой по умолчанию.</p>

<p>RETAINVRAM              Дает указание сохранить видеопамять.        rvm</p>
<p>                        Этот параметр игнорируется.</p>

<p>UNIQUESETTINGS          Запускает программы DOS в отдельных DOS-    uus</p>
<p>                        сеансах. Не является настройкой по</p>
<p>                        умолчаний.</p>

<p>USEHMA                  Дает указание использовать НМА (верхние     hma</p>
<p>                        адреса памяти). Значение по умолчанию.</p>

<p>VESA                    Дает программам DOS получать доступ к       vsa</p>
<p>(работает в REALMODE)   продвинутым графическим возможностям.</p>

<p>WINDOWED                Запускает приложение в окне, а не в         win</p>
<p>                        полноэкранном режиме. Настройка по</p>
<p>                        умолчанию.</p>

<p>WINLIE                  Не позволяет программам DOS обнаруживать    lie</p>
<p>                        W95. Не яаляется параметром по умолчанию.</p>

<p>XMSLOCKED               Дает указание блокировать память XMS.       Xml</p>

<p>В файле APPS.INF доступны, но не реализованы следующие параметры:</p>

<p>DISPLAYTBAR (dtb) Отображает панель инструментов.</p>
<p>EXCLMOUSE (exm)   Разрешает режим монопольного использования мыши</p>
<p>QUICKEDIT (qme)   Активизирует для мыши режим быстрого редактирования</p>
<p>WARNIFACTIVE (wia). Позволяет подавать предупреждения, если приложение</p>
<p>                    DOS еще активно</p>

<p>Справочник по разделам</p>
<p>В  нижеприведенных  таблицах описаны все ключевые слова и значения, ассоци-</p>
<p>ированные с конкретными разделами. Синтаксис раздела [Version] приведен ни-</p>
<p>же.  Квадратные  скобки используются для обозначения начала нового раздела.</p>
<p>Для  того чтобы настройки INF были понятны W95 и реестру, квадратные скобки</p>
<p>обязательно должны присутствовать.</p>

<p>[Version]</p>
<p>Signature=$CHICAGO$</p>
<p>Class=name_of_class</p>
<p>Provider=%File_creator%</p>
<p>LayoutFile=filename.inf</p>

<p>Ключевое слово Значение       Описание</p>

<p>Signature      $Chicago$    Задает операционную систему для INF-файла.</p>
<p>                            На момент написания большинства INF-файлов</p>
<p>                            кодовое название Windows 95 было следующим:</p>
<p>                            Chicago.</p>

<p>Class         name_of_class Указывает класс, который будет определен в ре-</p>
<p>                            естре. Список общих классов устройств, которые</p>
<p>                            вы можете ввести сюда, приведен в данном при-</p>
<p>                            ложении ранее.</p>

<p>LayoutFile     filename.inf Эта строка определяет имя INF-файла, содержа-</p>
<p>                            щего имена исходного диска и файлов, которые</p>
<p>                            должны быть включены для инсталляции этого</p>
<p>                            устройства. Если его не определить, то по умол-</p>
<p>                            чанию файл имеет имя LAYOUT.INF. Если вы не</p>
<p>                            включите эти данные в раздел Version, то должны</p>
<p>                            будете включить в файл APPS.INF разделы</p>
<p>                            SourceDiskName и SourceDiskFiles.</p>

<p>Синтаксис раздела [Manufacturer] приведен ниже.</p>

<p>[Manufacturer]</p>
<p>"manufacturer" %string_value%=manufacturer_section</p>

<p>Информация раздела [Manufacturer]</p>

<p>Ключевое слово          Описание</p>

<p>"manufacturer"          Имя производителя этого устройства, заключенное в</p>
<p>                        кавычки. Сюда можно включить любую строку. Это клю-</p>
<p>                        чевое слозо является необязательным.</p>

<p>%string_value%          Указывает имя строки, включенной в раздел Stings</p>
<p>                        INF-файла. Строки должны быть заключены в символы</p>
<p>                        процента (%).</p>

<p>manufacturer_section    Указывает на раздел Manufacturer Name в INF-файле.</p>

<p>Раздел [Manufacturer Name] включает описания устройства для указанного уст-</p>
<p>ройства  Ключевые  слова,  используемые  в этом разделе, описаны в таблице.</p>
<p>Синтаксис этого раздела выглядит следующим образом:</p>

<p>[name_of_manufacturer]</p>
<p>description of deviсe=install_section,ID_of_device[compatible_device_IDs,...]</p>

<p>Информация раздела [Manufacturer Name]</p>

<p>Ключевое слово           Описание</p>

<p>description_of_device      Описание инсталлируемого устройства.</p>
<p>install_section            Указывает имя раздела Install для этого устройства.</p>
<p>ID_of_device               Идентификатор (ID) инсталлируемого устройства.</p>
<p>[compatible_device_IDs,...] Содержит Ссылки на устройства, совместимые с</p>
<p>                            данным. В этот список можно включить несколько</p>
<p>                            устройств, разделив их запятыми.</p>

<p>Раздел [File List] можно использовать для указания файлов, которые вы хоти-</p>
<p>те скопировать, переименовать или удалить. В зависимости от элемента разде-</p>
<p>ла [Install] вы можете использовать три следующих синтаксических параметра:</p>

<p>[file_list section]</p>
<p>new_filename, old_filename</p>

<p>Эта  конструкция  используется для элементов RenFiles. Допускается вклююние</p>
<p>любого количества элементов new_filename, old_filename.</p>

<p>Для элементов DelFiles используется следующий синтаксис:</p>

<p>[file_list section]</p>
<p>filename</p>

<p>Параметр filename обозначает имя файла, который вы хотите удалить.</p>

<p>Для   элемента   CopyFiles   используется  следующий  синтаксис.  Параметры</p>
<p>source_filename и temporary_filename в этой конструкции являются необязате-</p>
<p>льными.</p>

<p>[file_list section]</p>
<p>destination_filename,source_filename,temporary_filename</p>

<p>Ниже  приведен  образец  синтаксиса раздела [Install]. Этот раздел включает</p>
<p>дополнительные  разделы  INF-файла, которые содержат описания устройства. В</p>
<p>правой части выражения, после знака равенства, можно указать несколько зна-</p>
<p>чений, разделенных запятыми.</p>

<p>[name_of_install_section]</p>
<p>LogConfig=section_name</p>
<p>Copyfiles=file_list_section</p>
<p>Renfiles=file_list_section</p>
<p>DelFiles=file_list_section</p>
<p>UpdateInis=UpdateIni_section_name</p>
<p>UpdateIniFields=UpdateIniFields_section_name</p>
<p>AddReg=AddRegitry_section</p>
<p>DelReg=DelRegitry_section</p>
<p>Ini2Reg=IniToRegistry_section</p>
<p>UpdateCfgSys=UpdateConfig_section</p>
<p>UpdateAutoBat=UpdateAutoexec_section</p>
<p>Reboot или Restart</p>

<p>Информация раздела [Install]</p>

<p>Ключевое слово             Значение         Описание</p>

<p>[name_of_install_section]                    Содержит имя устройства, соответ-</p>
<p>                                             ствующего информации, приведен-</p>
<p>                                             ной в этом разделе. В разделе</p>
<p>                                             ManufacturerName INF-файла дол-</p>
<p>                                             жна присутствовать ссылка на</p>
<p>                                             этот раздел</p>

<p>LogСonfig                section_name        Содержит информацию о разделах</p>
<p>                                             логической конфигурации уст-</p>
<p>                                             ройства. Значения section_name</p>
<p>                                             указывают на разделы INF-файла</p>
<p>                                             в которых содержится информа-</p>
<p>                                             ция о данном устройстве.</p>

<p>CopyFiles             file_list_section      Содержит информацию, необходимую</p>
<p>                                             для копирования указанного файла</p>
<p>                                             или файлов в каталог, указанный</p>
<p>                                             в разделе File_List. Вы можете</p>
<p>                                             дать системе указание скопировать</p>
<p>                                             отдельный файл. Для этого перед</p>
<p>                                             именем файла необходимо включить</p>
<p>                                             символ @. При этом файл будет</p>
<p>                                             скопирован в каталог</p>
<p>                                             DefaultDestDir, определенный в</p>
<p>                                             разделе DestinationDir INF-файла.</p>

<p>RenFiles             fiie_list_section       Позволяет переименовать указан-</p>
<p>                                             ный файл. Представляет собой</p>
<p>                                             указатель на раздел File_List</p>
<p>                                             INF-файла.</p>

<p>DelFiles             file_list_section       Позволяет удалить указанный</p>
<p>                                             файл. Представляет собой указа-</p>
<p>                                             тель на раздел FileList INF-файла.</p>

<p>UpdateInis          UpdateIni_section_name   Позволяет указать Значение INI-</p>
<p>                                             файла, которое вы хотите изме-</p>
<p>                                             нить через INF-файл. Представля-</p>
<p>                                             ет собой указатель на раздел</p>
<p>                                             Update INI.</p>

<p>UpdatelniFields UpdateIniFields_section_name Позволяет изменять, замещать</p>
<p>                                             или удалять отдельные элементы</p>
<p>                                             значений INI-файла (в отличие от</p>
<p>                                             предыдущего параметра, который</p>
<p>                                             изменял все значение целиком).</p>
<p>                                             Этот параметр представляет со-</p>
<p>                                             бой указатель на раздел Update</p>
<p>                                             IniFields.</p>

<p>AddReg                AddRegistry_section    Позволяет указать подключ или</p>
<p>                                             значение, которые требуется до-</p>
<p>                                             бавить в реестр. Представляет</p>
<p>                                             собой указатель на раздел Add</p>
<p>                                             Registry.</p>

<p>DelReg                Del_Registry_section   Позволяет указать подключ или</p>
<p>                                             значение, которые требуется уда-</p>
<p>                                             лить из реестра. Представляет</p>
<p>                                             собой указатель на раздел Delete</p>
<p>                                             Registry</p>

<p>Ini2Reg            IniToRegistry_section     Перемещает в реестр строки и</p>
<p>                                             разделы из INI-файла. Представ-</p>
<p>                                             ляет собой указатель на раздел</p>
<p>                                             Ini to Registry.</p>

<p>UpdateCfgSys        UpdateConfig_section     Содержит указатель на раздел</p>
<p>                                             Update Config. в этом разделе</p>
<p>                                             находятся команды, которые</p>
<p>                                             должны быть добавлены, удалены</p>
<p>                                             или переименованы в файле</p>
<p>                                             CONFIG.SYS.</p>

<p>UpdateAutoBat     UpdateAutoexec_section     Содержит указатель на раздел</p>
<p>                                             Update AutoExec. В этом разделе</p>
<p>                                             находятся команды, которые мо-</p>
<p>                                             дифицируют файл AUTOEXEC.BAT.</p>

<p>Reboot или Restart                           Команды, вызывающие перезапуск</p>
<p>                                             системы или перезагрузку ком-</p>
<p>                                             пьютера после завершения про-</p>
<p>                                             граммы установки.</p>

<p>Ниже  приведен  пример  синтаксиса  раздела [Logical Configuration]. Раздел</p>
<p>[LogConfig]  необходимо  указать  в разделе [Install]. Этот раздел содержит</p>
<p>информацию  о конфигурации системных ресурсов, включая IRQ, порты ввода/вы-</p>
<p>вода,  каналы  DMA и т. д. Для каждого включаемого элемента программа Setup</p>
<p>создает  запись  логической  конфигурации в двоичном формате и включает эту</p>
<p>информацию  в  реестр  в раздел driver. INF-файлы могут содержать несколько</p>
<p>(или ни одного) разделов [Logical Configuration]. Ключевые слова и значения</p>
<p>этого раздела описаны в таблице.</p>

<p>[LogConfig Section name]</p>
<p>ConfigPriority=value_of_priority</p>
<p>MemConfig=menory_range_settings</p>
<p>I/OConfig=ioport_settings</p>
<p>IRQConfig=irq_sectings</p>
<p>DMAConfig=dma_settings</p>

<p>Ключевое слово          Значение             Описание</p>

<p>ConfigPriority         value_of_priority     Содержит значение приоритета</p>
<p>                                             конфигурации для данного устрой-</p>
<p>                                             ства.</p>

<p>MemConfig          memory_range_settings     Указывает диапазон памяти для</p>
<p>                                             данного устройства.</p>

<p>I/OConfig           ioport_settings          Позволяет указать для устройства</p>
<p>                                             конфигурацию портов ввода/вывода.</p>

<p>IRQConfig            irq_settings            Содержит СПИСОК допустимых IRQ</p>
<p>                                             для данного устройства. Если</p>
<p>                                             устройство не использует IRQ,</p>
<p>                                             не следует включать эту</p>
<p>                                             строку в INF-файл.</p>

<p>DMAConfig             dma_settings           Указывает допустимые значения</p>
<p>                                             DMA для данного устройства.</p>

<p>Для параметров настройки, перечисленных в таблице, можно указывать не один,</p>
<p>а  несколько ресурсов. Однако, в процессе инсталляции будет использован то-</p>
<p>лько один из ресурсов, приведенных в списке. Чтобы указать несколько ресур-</p>
<p>сов  для  одного  устройства, вам потребуется создать соответствующее число</p>
<p>записей для каждого из ресурсов.</p>

<p>Ниже  приведен  пример  синтаксиса  раздела  [Update AutoExec]. Имя раздела</p>
<p>[UpdateAutoBat]  должно быть указано в разделе [Install]. Этот раздел соде-</p>
<p>ржит  команды, манипулирующие строками в файле AUTOEXEC.BAT. Ключевые слова</p>
<p>и значения этого раздела приведены в таблице.</p>

<p>[Update_autobat_section]</p>
<p>CmdDelete=command</p>
<p>CmdAdd=command</p>
<p>UnSet=environmentvariablename</p>
<p>PreFixPath=%ldid%</p>
<p>RemOldPath=%ldid%</p>
<p>TmpDir=%ldid%</p>

<p>Ключевое слово        Значение              Описание</p>

<p>CmdDelete               command         Указывает команду, которая должна</p>
<p>                                        быть удалена из файла AUTOEXEC.BAT.</p>
<p>                                        Эта строка обрабатывается перед</p>
<p>                                        строкой CmdAdd.</p>

<p>CmdAdd                  command         Указывает команду, которую требуется</p>
<p>                                        добавить в файл AUTOEXEC.BAT.</p>

<p>UnSet          environmentvariablename  Указывает переменную окружения, кото-</p>
<p>                                        рую вы хотите удалить из файла</p>
<p>                                        AUTOEXEC.BAT.</p>

<p>PreFixPath               %ldid%         Позволяет включить предопределенную</p>
<p>                                        фиксированную переменную path в форме</p>
<p>                                        логического идентификатора каталога</p>
<p>                                        (logical directory identificator, LDID).</p>

<p>RemOldPath               %ldid%         Позволяет указать путь, который должен</p>
<p>                                        быть удален из файла AUTOEXEC.BAT.</p>

<p>TmpDir                   %ldid%         Позволяет указать временный каталог на</p>
<p>                                        время установки.</p>

<p>Ниже  приведен  пример  синтаксиса  раздела  [Update  Config].  Имя раздела</p>
<p>[Update_config_section] должно быть задано в разделе [Install]. Этот раздел</p>
<p>содержит команды манипуляции со строками в файле CONFIG.SYS. Ключевые слова</p>
<p>и значения этого раздела описаны в таблице.</p>

<p>[Update_config_section]</p>
<p>DevRename=current_name,new_name</p>
<p>DevDelete=driver_name</p>
<p>DevAddDev=driver_name,configkeyword</p>
<p>Stacks=dos_stack_values</p>
<p>Buffers=dos_buffer_values</p>
<p>Files=dos_buffer_values</p>
<p>LastDrive=dos_lastdrive_value</p>

<p>Ключевое слово               Значение                 Описание</p>

<p>DevRename             current_name,new_name   Позволяет переименовать драйверы</p>
<p>                                              устройств, вызываемые из файла</p>
<p>                                              CONFIG.SYS. Раздел может содержать</p>
<p>                                              несколько строк DevRename.</p>
<p>                                              Записи DevRename обрабатываются</p>
<p>                                              первыми, прежде, чем начнется</p>
<p>                                              обработка каких-либо других</p>
<p>                                              записей раздела.</p>

<p>DevDelete               driver_name           Позволяет указать драйверы</p>
<p>                                              устройств, которые должны быть</p>
<p>                                              удалены из файла CONFIG.SYS.</p>
<p>                                              Раздел может содержать несколько</p>
<p>                                              записей DevDelete.</p>

<p>DevAddDev          driver_name,configkeyword  Позволяет указать новый драйвер,</p>
<p>                                              который должен быть добавлен в</p>
<p>                                              файл CONFIG.SYS. Раздел может</p>
<p>                                              содержать несколько записей</p>
<p>                                              DevAddDev.</p>

<p>Stacks            dos_stack_values            Указывает значение Stacks= в</p>
<p>                                              файле CONFIG.SYS.</p>

<p>Buffers           dos_buffer_values           Указывает значение Buffers= в</p>
<p>                                              файле CONFIG.SYS.</p>

<p>Files             dos_file_values             Указывает значение Files= в</p>
<p>                                              файле CONFIG.SYS.</p>

<p>LastDrive         dos_lastdrive_value         Указывает значение lastdrive=</p>
<p>                                              в файле CONFIG.SYS.</p>

<p>Ниже приведен пример синтаксиса раздела [Update INI]. Раздел [Update INI]</p>
<p>необходимо указать в разделе [Install] записью UpdateINIs. Этот</p>
<p>раздел добавляет, удаляет или замещает записи в указанном INI-фаЙле.</p>
<p>Ключевые слова и значения для этого раздела описаны в таблице.</p>

<p>[Update_ini_section]</p>
<p>ini-file,ini-section,original_entry,new_entry, options</p>

<p>Значение            Описание</p>

<p>options             Необязательные флаги операции, которые могут принимать</p>
<p>                    одно из следующих значений</p>

<p>   0                Значение по умолчанию. Ищет ключ (имя записи)</p>
<p>                    original_entry, игнорируя его значение. Если ключ при-</p>
<p>                    сутствует, соответствующая запись заменяется на</p>
<p>                    new_entry. Если original_entry равна NULL, new_entry</p>
<p>                    добавляется безусловно. Если new_entry равна NULL,</p>
<p>                    original_entry удаляется.</p>

<p>   1                Ищет запись original_entry по ключу и значению. Обнов-</p>
<p>                    ление выполняется только в том случае, когда совпадают и</p>
<p>                    ключ, и значение записи original_entry.</p>

<p>   2                Ищет запись, ключ которой совпадает с указанным в</p>
<p>                    original entry. Если запись уже существует, она не за-</p>
<p>                    мещается значением, указанным вами в new_entry.</p>

<p>   3                Ищет запись, ключ и значение которой совпадают с</p>
<p>                    указанными в original_entry. Если такая запись существует,</p>
<p>                    она замещается new_entry.</p>

<p>Ниже приведена синтаксическая конструкция раздела [Update IniFields].</p>
<p>Имя раздела [UpdatelniFields] должно быть указано элементом</p>
<p>[UpdatelniFieldsl в разделе [Install]. Утверждения этого замещают,</p>
<p>добавляют или удаляют поля в указанной записи INI-файла. В отличие от</p>
<p>раздела [Update INI], команды из данного раздела работают с фрагмента-</p>
<p>ми записей, а не с записями в целом.</p>

<p>[update_inifields_section]</p>
<p>ini-file,ini-section,profile_name,old_field,new_field</p>

<p>Если в строке INI-файла для указанной записи присутствовал комментарий,</p>
<p>он удаляется. Модификаторы old_field и new_field являются необяза-</p>
<p>тельными.</p>

<p>Раздел [Add Registry] позволяет добавлять в реестр ключи и значения.</p>
<p>Кроме того, существует необязательная возможность установить фактиче-</p>
<p>ское значение. Имя раздела [add_registry_section] должно быть задано</p>
<p>элементом AddReg раздела [Install]. Синтаксис раздела выглядит следую-</p>
<p>щим образом:</p>

<p>[add_registry_section]</p>
<p>reg_root_string</p>

<p>В этот раздел вы можете включить подключи, имена значений и</p>
<p>(необязательно) сами значения.</p>

<p>Раздел [Delete Registry] используется для удаления из реестра подклю-</p>
<p>чен и имен значений. Синтаксис этого раздела выглядит следующим обра-</p>
<p>зом:</p>

<p>[del_registry_section]</p>
<p>reg_root_string,subkey</p>

<p>Имя этого раздела должно быть указано элементом DelReg в разделе</p>
<p>[Install]. Каждый элемент, включенный в этот раздел, удалит из реестра</p>
<p>подключ или значение.</p>

<p>Раздел [Ini to Registry] позволяет перемещать в реестр строки и разде-</p>
<p>лы из INI-файла. Эта операция или создает в реестре новый элемент, или</p>
<p>подключ или значение.</p>

<p>Имя раздела [ini_to_registry section] должно быть указано элементом</p>
<p>lni2Reg в разделе [Install].</p>

<p>Раздел [DestinationDirsI позволяет определить каталог назначения для</p>
<p>раздела [File_List]. Ссылка на имя раздела [DestinationDirs] должна</p>
<p>присутствовать в одном из следующих трех элементов раздела [Install]:</p>
<p>DelFiles, CopyFiles или RenFiles. Синтаксис раздела приведен ниже.</p>

<p>Более подробную информацию можно найти в таблице.</p>

<p>[DestinationDirs]</p>
<p>file_list=ldid,subdirectory</p>
<p>DefaultDestDir=ldid,subdirectory</p>

<p>Ключевое слово       Значение             Описание</p>

<p>file_list             ldid,subdirectory    Указывает имя раздела FileList.</p>

<p>                      subdirectory         Указывает каталог, находящийся</p>
<p>                                           в каталоге ldid. Это значение</p>
<p>                                           необязательно.</p>

<p>                      ldid                 Указывает логический идентификатор</p>
<p>                                           диска. Список допустимых значений</p>
<p>                                           ldid приведен далее.</p>

<p>DefaulDestDir                              Позволяет указать каталог-приемник</p>
<p>                                           по умолчанию для всех неупомянутых</p>
<p>                                           разделов File_List. Этот параметр</p>
<p>                                           не является обязательным. По умол-</p>
<p>                                           чанию W95 использует каталог</p>
<p>                                           LDID_WIN.</p>

<p>Раздел [SourceDisksFilesj используется для указания исходных файлов,</p>
<p>используемых в процессе инсталляции. Кроме того, с помощью этого разде-</p>
<p>ла можно указать исходные диски, содержащие эти файлы. Синтаксис раз-</p>
<p>дела очень прост:</p>

<p>[SourceDisksFiles]</p>
<p>name_of_source_disk=disk_number</p>

<p>Элемент disk_number определяется в разделе [SourceDisksNames], кото-</p>
<p>рый использует следующий синтаксис:</p>

<p>[SourceDisksNames]</p>
<p>disk_ordinal=description_of_disk,label,serial_number</p>

<p>Раздел [ClassInstall] устанавливает новый класс устройства в разделе</p>
<p>реестра [Class]. Синтаксис раздела [ClassInstall] приведен ниже.</p>
<p>Подробную информацию о значениях и элементах, которые используются в</p>
<p>этом разделе, можно найти в таблице выше.</p>

<p>[ClassInstall]</p>
<p>CopyFiles=fils_list_section</p>
<p>RenFiles=fils_list_section</p>
<p>DelFiles=fils_list_section</p>
<p>UpdateInis=UpdateIni_section_name</p>
<p>UpdateIniFields=UpdateIniFields_section_name</p>
<p>AddReg=AddRegistry_section</p>
<p>DelReg=DelRegistry_section</p>

<p>Наконец, последним разделом INF-фаила является раздел [Strings]. Этот</p>
<p>раздел определяет один или несколько строковых ключей. Синтаксис этого</p>
<p>раздела приведен ниже.</p>

<p>[Strings]</p>
<p>string_key="valve"</p>

<p>Ключевое слово string_key обозначает строковый ключ, формирующийся</p>
<p>из буквенно-цифровых символов, например, MfgName. Хотя раздел</p>
<p>[Strings] обычно является последним в INF-файле, строковые ключи</p>
<p>можно использовать везде, где допустимо употребление строк.</p>
<p>Программа Setup подставляет вместо строкового ключа строку, заданную</p>
<p>элементом "value" и в дальнейшем использует именно ее, например:</p>
<p>MSFT="Microsoft"</p>
<p>Встпетив строку MSFT. поогоамма Setup интерпретирует ее как Microsoft</p>

<p>Значения LDID</p>
<p>В таблице перечислены допустимые значения LDID (logical disk identifier),</p>
<p>которые вы можете использовать в INF-файлах.</p>

<p>  ID           Обозначает</p>

<p>  00           Пустой LDID; используется для создания нового LDID</p>
<p>  01           Исходное устройство:\путь</p>
<p>  02           Временный каталог Setup; используется только в процессе</p>
<p>                                                     установки W95</p>
<p>  03           Каталог Uninstall</p>
<p>  04           Каталог Backup</p>
<p>  10           Каталог Windows</p>
<p>  11           Каталог SYSTEM</p>
<p>  12           Каталог lOsubsys</p>
<p>  13           Каталог COMMAND</p>
<p>  14           Каталог Control Panel</p>
<p>  15           Каталог Printers</p>
<p>  16           Каталог Workgroup</p>
<p>  17           Каталог INF</p>
<p>  18           Каталог Help</p>
<p>  19           Каталог Administration</p>
<p>  20           Каталог Fonts</p>
<p>  21           Каталог Viewers</p>
<p>  22           Каталог VMM32</p>
<p>  23           Каталог Color</p>
<p>  25           Каталог Shared</p>
<p>  26           Каталог Winboot</p>
<p>  27           Машинно-зависимый каталог</p>
<p>  28           Каталог Winboot Host</p>
<p>  30           Корневой каталог загрузочного устройства</p>
<p>  31           Корневой каталог хост-диска виртуального загрузочного устройства</p>
<p>  32           Каталог с прежней версией Windows (если есть)</p>
<p>  33           Каталог с прежней версией MS-DOS (если есть)DB</p>

