<h1>Как корректно прервать выполнение SQL-запроса?</h1>
<div class="date">01.01.2007</div>


<p>Дает ли Delphi возможность корректно прервать выполнение SQL-запроса к серверу Oracle с помощью BDE? Например, чтобы при использовании с SQL Plus после отправки SQL-запроса на выполнение на экране появлялось окно с кнопкой Cancel, которое давало бы возможность в любой момент прервать выполнение этого запроса?</p>

<p>Насколько мне известно, для этой цели лучше всего использовать функции Oracle Call Interface (низкоуровневый API Oracle). В комплекте поставки Oracle есть соответствующие примеры для C, и переписать их на Pascal несложно. </p>

<p>Некоторые драйверы SQL Link позволяют прекратить выполнение запроса, если время его выполнения превышает заранее заданное значение (параметр MAX QUERY TIME соответствующего драйвера). Однако драйвер ORACLE, к сожалению, в их число не входит. </p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
