<h1>Введение</h1>
<div class="date">01.01.2007</div>


<p>Любую современную программу или программную технологию можно представить как совокупность программных "слоев". Каждый из этих слоев производит свою собственную работу, которая заключается в повышении уровня абстракции производимых операций. Так, самый низший слой (слои) вводит понятия, которые позволяют абстрагироваться от используемого оборудования; следующий слой (слои) позволяет программисту абстрагироваться от сложной последовательности вызовов функций, вводя такое понятие как протокол и т.д. Практически в любом современном программном продукте можно обнаружить и выделить около десятка последовательных слоев абстракции.</p>
<p>Абстракция от оборудования и низкоуровневых протоколов вводится в ядра операционных систем в виде библиотек API (Application Program Interface). Однако современные тенденции приводят к необходимости абстрагирования и от самих операционных систем, что позволяет переносить программы с одной операционной системы на другую путем простой перекомпиляции (транслируемые программы, в основном, вообще не требуют никаких действий по переносу).</p>
<p>Абстракцию, которая доступна программисту в виде библиотек API можно назвать базовой. Это самый низкий уровень абстракции, который доступен для прикладного программирования. На уровне ядра системы доступны и более низкие уровни абстракции, однако для их использования необходимо разрабатывать специализированные программы (драйвера, модули). Базовый уровень абстракции (API) предоставляет максимально широкие возможности для прикладного программирования и является наиболее гибким. Однако, программирование с использованием API является гораздо более трудоемким и приводит к значительно большим объемам исходного кода программы, чем программирование с использованием дополнительных библиотек.</p>
<p>Дополнительные библиотеки поставляются со многими средствами разработки с целью уменьшения трудоемкости и сроков разработки программ, что в итоге приводит к повышению их конкурентноспособности. Но применение дополнительных библиотек абстракций приводит к резкому увеличению размеров откомпилированных программ, из-за того что в программу включается код используемых библиотек, к тому же это включение зачастую бывает неэффективным - в программу включаются неиспользуемые участки кода. Кроме того, чем больше уровень абстракции библиотеки, тем сложнее ее код, и тем больше трудностей возникает при решении сложных задач. Приходится учитывать множество взаимосвязей и взаимных влияний отдельных элементов и процессов библиотеки друг на друга. Кроме того, структура и функциональность любой библиотеки обычно рассчитывается на удовлетворение всех потенциально возникающих задач, что приводит к ее громоздкости и неэффективности.</p>
<p>В Delphi используется очень мощная и сложная библиотека VCL (Visual Components Library), которая помимо непосредственных абстракций вводит также и множество своих функциональных классов. В этой библиотеке находятся компоненты для визуального отображения информации, работы с базами данных, с системными объектами, компоненты для работы с Internet-протоколами, классы для написания своих COM-объектов и многое другое. Модули библиотеки подключаются к компиляции по мере необходимости, однако базовый размер простейшего диалогового проекта с одной формой превышает 300кБ (со статически скомпонованной библиотекой). И такой размер во многих случаях может оказаться слишком большим, особенно если программа не требует большой функциональности в интерфейсе.</p>
<p>Для решения этой проблемы можно отказаться от использования библиотеки VCL, и программировать, используя базовый набор функций Win32 API. Однако, если при разработке линейных, недиалоговых, нерезидентных программ не возникает никаких трудностей, то разработка программ, требующих активного взаимодействия с пользователем или системой, становится трудоемкой. Структурное программирование, рекомендуемое в таких случаях, оказывается неэффективным и трудоемким.</p>
<p>Данная статья посвящена проблеме создания и использования компактной объектно-ориентированной библиотеки, которая бы облегчила построение небольших и эффективных программ на основе Win32 API.</p>
