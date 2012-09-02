<h1>Доступ в программах</h1>
<div class="date">01.01.2007</div>

<p>Сергей Радкевич (mailto:level3@mail.ru, ICQ:15320127)</p>
<p>В данной работе рассматриваются способы хранения информации о правах доступа к различным частям программ и данных. Работа может быть интересна программистам, реализующим многопользовательские системы.</p>
<p>Термины</p>
<p>При создании приложения, которое используют несколько пользователей, возникает задача ограничения доступа. Существует несколько способов решения этой задачи. Выбор оптимального способа зависит от дополнительных условий и особенностей приложения.</p>
<p>Самый простой способ ограничения доступа &#8211; когда есть список пользователей, которым разрешено работать со всей программой целиком. Для его реализации потребуется одна таблица с полем &#171;пользователь&#187;. Проверке на входе в программу &#8211; единственная проверка.</p>
<p>В более сложном случае нужно разграничивать доступ к отдельным частям (функциям) программы и проверок становиться много, а не одна. Поэтому есть понятия:</p>
<p>&#183; пользователь;</p>
<p>&#183; программа;</p>
<p>&#183; функция программы<br>
<p>часть программы, позволяющая пользователю выполнить некоторое осмысленное и нужное действие.</p>
<p>&#183; право;<br>
<p>пользователю может быть дано или не дано право использовать некоторую функцию программы.</p>
<p>&#183; роль (набор прав);</p>
<p>&#183; группа пользователей.</p>
<p>1. Пользователи, права, роли и группы</p>
<p>Роли и группы могут быть использованы как дополняющие друг друга (ортогональные) концепции. Поэтому есть четыре варианта их применения: не использовать ни одну из них, использовать по только группировку пользователей, использовать только группировку прав, использовать группировку пользователей и прав одновременно.</p>
<p>1.1. Набор прав</p>
<p>В этом случае некоторому пользователю дается (или не дается) право выполнять некоторую операцию. Так как операции и пользователи связаны отношением &#171;многие &#8211; ко - многим&#187; здесь потребуются уже три таблицы: &#171;пользователи&#187;, &#171;операции&#187;, &#171;пользователь имеет право на операцию&#187;.</p>
<p><img src="/pic/clip0046.gif" width="576" height="156" border="0" alt="clip0046"></p>
<p>1.2. Группы пользователей</p>
<p>В случае если программой пользуется большое количество пользователей, то назначать права каждому пользователю становится неудобно. Тогда вводят понятие &#171;группа пользователей&#187;. Сначала пользователей объединяют в группы (например, на территориальной основе, по возрастному признаку, совершеннолетние &#8211; несовершеннолетние), а затем определяют права для групп. При этом при добавлении нового пользователя в систему вместо назначения ему прав достаточно просто добавить пользователя в нужную группу. Пользователи и группы в общем случае связаны соотношением &#171;многие &#8211; ко &#8211; многим&#187;. При этом иногда возникает потребность запретить какое-то право отдельному пользователю группы. Кроме того, права могут назначаться как группам, так и отдельным пользователям.</p>
<p>Для этого потребуется следующая структура:</p>
<p><img src="/pic/clip0047.gif" width="612" height="156" border="0" alt="clip0047"></p>
<p>1.3. Ролевая модель</p>
<p>Если у программы много функций, которые удобно логически сгруппировать, то вводят понятие &#171;роль&#187; - набор функций, необходимых для выполнения некоторой работы. Так, например, для программы автоматизации школы такими ролями могут быть &#171;ученик&#187;, &#171;учитель&#187;, &#171;родитель&#187;, &#171;завуч&#187;. Пользователь может иметь несколько ролей, например, быть одновременно учителем и родителем. Т.е. пользователи и роли связаны отношением &#8220;многие &#8211; ко &#8211; многим&#8221;, так же как и пользователи и группы в схеме с группами пользователей. В обеих схемах можно не давать возможности назначать индивидуальным пользователям индивидуальные права. В этом случае потребуется такая схема:</p>
<p><img src="/pic/clip0048.gif" width="612" height="144" border="0" alt="clip0048"></p>
<p>1.4. Модель с ролями и группами</p>
<p>Чтобы обеспечить максимальную гибкость для ограничения доступа ролевую модель и группы пользователей объединяют в общую модель. В этом случае роли могут назначаться группам, что еще уменьшает объем администрирования.</p>
<p>В итоге получается тетраэдр, в вершинах которого находятся пользователи, группы, роли и права, а на ребрах &#8211; таблицы для моделирования отношения &#171;многие &#8211; ко &#8211; многим&#187;<br>
&nbsp;<br>
<img src="/pic/clip0049.gif" width="533" height="201" border="0" alt="clip0049"><br>
<p>&nbsp;</p>
<p>1.5. Оптимизация</p>
<p>1.5.1. Маски прав</p>
<p>Если прав фиксированное количество, то можно завести в таблицах &#171;пользователь-право&#187;, &#171;группа-право&#187; и &#171;роль-право&#187; дополнительные поля, например по одному полю на каждое право. Тогда таблицу &#171;право&#187; можно сделать подразумеваемой. Если прав меньше 32, то можно все дополнительные поля объединить в одно и назвать это &#171;маской прав&#187;.</p>
<p>1.5.2. Эффективные права</p>
<p>Кроме того, можно вычислить эффективные права и добавить поле в таблицу &#171;пользователь-право&#187;. Это потребует обновления этого поля при каждом изменении других таблиц, однако существенно ускорит проверку прав.</p>
<p>2. Объекты</p>
<p>Права в программе могут разграничиваться не только по функциям, но и по объектам. К примеру, один и тот же пользователь может иметь право &#171;только чтение&#187; для одной папки и &#171;полный доступ&#187; для другой папки.</p>
<p>2.1. Права на объекты</p>
<p>В этом случае права должны даваться не вообще, а на конкретные объекты. Однако так как на разные объекты могут даваться одинаковые права, то можно воспользоваться следующей структурой:</p>
<p><img src="/pic/clip0050.gif" width="612" height="171" border="0" alt="clip0050"></p>
<p>Т.е. дополнить таблицу &#171;пользователь &#8211; право&#187; колонкой, в которой будет указано, к какому объекту это право дано. Точно так же должны быть расширены таблицы: роль&#8211;право, группа&#8211;право и группа&#8211;роль. Таким образом, разграничивая доступ к объектам, мы добавляем новое измерение к модели.</p>
<p>Если же позволить назначать права не только на объекты, но и на группы объектов (т. к. назначать права на каждый объект в отдельности трудоемко), то получаем шесть сущностей (пользователь, группа, право, роль, объект, группа), которые объединяются восемью тройными связями. Восемью, так как у нас три пары сущностей, а 2^3 = 8. Еще есть три двойные связи (право-роль, пользователь-группа и объект-группа).</p>
<p>Это подводит к мысли &#8211; нельзя ли обойтись общей таблицей &#171;право на&#187;?</p>
<p>2.2. Иерархии объектов</p>
<p>Объектов, как правило, очень много, существенно больше, чем пользователей и прав. Поэтому объекты не только объединяют в группы, но и организовывают в иерархии (вероятно, появятся системы, в которых группы и роли так же образуют иерархии). Иерархию можно изобразить в виде дерева. При этом права могут назначаться непосредственно листу или узлу, либо могут браться права узла более близкого к корню. Это называется наследованием прав.</p>
<p>В случае наследования прав возникает вопрос &#8211; что делать, если установлен флаг &#171;права наследуются&#187; и права определены непосредственно для самого объекта. Одно из решений &#8211; объединять такие права (как на допуск, так и на недопуск), другое &#8211; не позволять определять права для объекта, если установлен флаг &#171;права наследуются&#187;.</p>
<p>В случае если берутся либо права предка, либо права объекта, можно завести у объекта поле &#8211; откуда брать права. Это поле является кешем и должно обновляться при изменении поля &#171;права наследуются&#187; у объекта и у его предков.</p>
<p>Заключение</p>
<p>В данной работе рассмотрены различные схемы хранения информации о правах доступа. Для конкретной системы нужно строить свою схему исходя из требований по быстродействию и уровню ограничения доступа.<br>
&nbsp;<br>
&nbsp;<br>
<p>Сергей Радкевич (mailto:level3@mail.ru, ICQ:15320127)</p>
<p>Взято из<a href="https://delphi.chertenok.ru" target="_blank"> http://delphi.chertenok.ru</a></p>
