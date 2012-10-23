<h1>База данных и система управления базами данных</h1>
<div class="date">01.01.2007</div>


<p>База данных - это набор структурированной информации, предназначенный для совместного использования несколькими пользователями одновременно. Отдельные элементы данных в базе данных связаны между собой логическими связями, взаимозависимы. Именно понятие “структурированная” и “для совместного использования” отличают базу данных от простых файлов с данными, которые тоже являются наборами данных.</p>
Структурированность означает, что данные имеют некоторую логическую структуру, некоторую схему, модель, которая связывает между собой разные данные. В файле же есть только физический порядок - “первый”, “следующий за” и т.д. В базе данных связи имеют логическую связь “стоит столько-то”, “называется так-то” и т.д. В качестве способа хранения базы данных может использоваться файл или группа файлов. Но для файла операции доступа будут иметь вид "найти запись номер 5" или "прочитать запись, байты с 30 по 37 которой имеют значение "секретно"". Доступ же к базе данных будет иметь вид типа "найти название документа, у которого стоит гриф "секретно"".</p>
В рассматриваемом нами примере резервирования авиабилетов, база данных - это информация о рейсах, список проданных билетов и т.д. Информация является связанной, то есть билеты на рейсы существуют не сами по себе, а должны быть согласованы с рейсами. Например, при отмене того или иного рейса надо также каким-то образом обрабатывать проданные на него билеты. Стоит отметить, что даже если по своему назначению и по своим внутренним связям две базы данных идентичны, но описывают разные реальные объекты, то есть, содержат разные данные, то это будут две разные базы данных. Hапример, если авиакомпании "Внуковские авиалинии" и АЭРОФЛОТ используют систему резервирования билетов, купленную у одной и той же фирмы, но используют их независимо, то это будут разные базы данных. Итак, основная ценность базы данных заключается в самих данных, в возможности находить, модифицировать эти данные.</p>
Кроме того, база данных предполагает наличие некоторого программного обеспечения, позволяющего пользователям работать с базой данной. Это программное обеспечение разрабатывается с помощью инструменталььных программных средств, называемых системой управления базами данных (СУБД). С помощью СУБД можно создавать базы данных, модифицировать данные в базе данных, вносить новые данные, разрабатывать пользовательские приложения не заботясь при этом о способе физического представления данных. Кроме того, СУБД должна выполнять некоторые задачи по администрированию и поддержанию непротиворечивости данных. То есть СУБД - это инструмент, с помощью которого создается та или иная конкретная база данных.</p>
В примере про систему резервирования билетов к СУБД относятся как средства, с помощью которых разработаны программа, с которой работают операторы, сидящие в авиакассах, так и программа, с помощью которой администратор меняет список рейсов. Утилита, с помощью которой по ночам создается резервная копия всей базы, также относится к СУБД.</p>
Еще раз отметим разницу между базой данных и системой управления базой данных. Если какая-то фирма пишет в объявлении, что она продает базу данных, то это означает, что она продает информацию. Если же в рекламе написано о СУБД, то следует ожидать, что Вам предложат программные средтсва, с помощью которых Вы соберете свою собственную базу данных. Хотя, в реальной жизни, понятия базы данных и системы управления базой данных часто смешивают.</p>
Иногда к СУБД относят и те прикладные программы, которые предназначены для доступа пользователей к базе данных. Стоит четко отличать СУБД от прикладных программ. Другие авторы относят прикладные программы, работающие с базой данных к самому понятию “база данных”. В этом случае понятие базы данных становится очень близким к понятию “информационная система”. Мы же, в дальнейшем рассмотрении прикладные программы будем выносить в свою собственную категорию (называемую, также, приложениями).</p>
Помимо базы данных, иногда встречается и другой термин - “банк данных”. Однозначного толкования данного термина не существует, но обычно его употребляют или вместо термина база данных, или для обозначения нескольких баз данных, логически связанных между собой.</p>
&nbsp;</p>
<div class="author">Автор: Грачев А.Ю.</div>
<p>Грачев А.Ю., Введение в СУБД Informix</p>
