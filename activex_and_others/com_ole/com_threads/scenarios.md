---
Title: Понимание потоковых моделей в COM при программировании на Delphi
Author: Бин Ли
Date: 01.01.2007
---

# Понимание потоковых моделей в COM при программировании на Delphi

::: {.date}
01.01.2007
:::

Автор: Бин Ли

- [Введение](./)
- [Основы многопоточности и COM](basics/)
- [Сценарии комбинаций потоковых моделей](scenarios/)
- [Заключение](conclusion/)

## Сценарии комбинаций потоковых моделей


### Сценарий \#1: Клиент STA и однопотоковый сервер

Внутренний сервер.

Клиентский поток STA, создающий объект в однопотоковом сервере,
принимает прямое подключение к объекту, если этот поток живет в главном
STA клиента. В противном случае COM создает объект в главном STA клиента
и получает прокси (заместителя) к требуемому потоку. Почему COM
поступает так? Ответ простой: однопотоковый сервер сообщил COM, что он
может обслуживать поступающие вызовы к своим объектам только в одном
потоке. COM заметит это и несомненно выполнит этот однопотоковый запрос,
не \"потревожив\" сервер. Следовательно, любой многопотоковый клиент,
желающий сообщить что-либо этому серверу, будет способен сделать это
только потому, что COM заставить выполнить этот запрос в одном потоке
STA. Для клиента STA COM выберет главный STA в качестве единственного
потока STA.

Внешний сервер.

Все клиентские потоки STA будут пользоваться заместителями,
маршалируемыми и обслуживаемыми главным (единственным) STA внешнего
сервера.

### Сценарий \#2: Клиент STA и сервер MTA

Внутренний сервер.

Клиентский поток STA, создающий объект из сервера MTA, получит прокси
(заместителя) к этому объекту, маршалированного из созданного COM MTA в
клиентском приложении. На первый взгляд это кажется странным, так как по
определению объект MTA должен иметь возможность прямого доступа вне
зависимости от того, какой поток создан, или откуда к нему производится
доступ. Другими словами, почему бы COM не создавать объект
непосредственно в STA запрашивающего клиента? Давайте попробуем понять,
что произойдет, если COM создаст экземпляр объекта непосредственно в
клиентском STA. Если COM создает объект MTA непосредственно в клиенте
STA, то с точки зрения клиента, объект живет в этом STA, но с точки
зрения сервера объект в действительности живет в MTA, т.е. он выглядит
так, как будто он может осуществлять все вызовы из любого потока в любое
время. Теперь, если клиент пытается передать интерфейс обратного вызова
методу этого объекта MTA (очевидно, что этот интерфейс нужен объекту,
расположенному в клиенте, а этот объект поддерживает только STA, так как
клиент работает в модели STA) и сервер пытается осуществить обратный
вызов через этот интерфейс, то у сервера нет способа узнать, что этот
интерфейс не в состоянии обслуживать одновременные вызовы из нескольких
потоков сервера (который размещается в MTA). Другими словами клиентский
объект, реализующий интерфейс обратного вызова может \"задохнуться\",
если сервер начнет производить одновременные вызовы из разных потоков.
Следовательно, создавая объект всозданном COM MTA и передавая прокси
(заместителя) обратно к затребовавшему его STA, любые обратные вызовы,
исходящие от сервера, будут производиться этим MTA и выстраиваться
последовательно через прокси в STA, который содержит объект,
обслуживающий обратный вызов.

Внешний сервер.

Все клиентские потоки STA, которым необходимо использование прокси,
маршалируются и обслуживаются в MTA внешнего сервера.

### Сценарий \#3: Клиент MTA и однопотоковый сервер

Внутренний сервер.

Клиентский поток MTA, создающий объект из однопотокового сервера, будет
принимать прокси к этому объекту, маршалированный созданным COM главным
STA в клиенте (полагая, что клиент еще не создан главным STA). Очевидно,
COM не может допускать прямого создания объектов однопотокового сервера
в MTA, так как он не сможет пережить одновременные вызовы из потоков
MTA.

Внешний сервер.

Все клиентские потоки MTA будут пользоваться прокси (заместителями),
маршалированными и обслуживаемыми главным (единственным) STA внешнего
сервера.

### Сценарий \#4: Клиент MTA и сервер STA

Внутренний сервер.

Клиентский поток MTA, создающий объект из сервера STA, получит прокси
(заместителя) к этому объекту, маршалированного, созданным COM STA в
клиентском приложении. Только это имеет смысл, так как сервер сказал
COM, что он может поддерживать только STA и поэтому нет способа, чтобы
COM прямо создавал объект в MTA, в котором другие потоки MTA преспокойно
\"завалят\" его! Таким образом, если он живет в STA, любые вызовы,
производимые потоками MTA, будут выстраиваться последовательно к STA,
который, по соглашению, как раз и является тем, с чем может работать
сервер.

Внешний сервер.

Все клиентские потоки MTA будут пользоваться прокси, маршалированными и
обслуживаемыми в каждом соответствующем STA внешнего сервера.

### Сценарий \#5: Однопотоковый клиент и сервер STA

Внутренний сервер.

В этом случае, очевидно, имеется только один главный поток в клиентском
приложении, в котором COM будет непосредственно создавать все объекты
сервера STA.

Внешний сервер.

Клиентский главный поток STA будет пользоваться прокси, маршалированным
и обслуживаемым в каждом соответствующем STA внешнего сервера.

### Сценарий \#6: Однопотоковый клиент и сервер MTA

Внутренний вервер.

Этот сценарий является недоделанным вариантом сценария \#2, в котором
имеется только один STA в клиенте, главный STA. Таким образом, по тем же
причинам, что и при сценарии \#2, COM будет создавать объект в созданном
COM MTA и возвращать прокси к главному потоку STA. Внешний сервер.
Клиентский главный поток будет пользоваться прокси, маршалируемым и
обслуживаемым в MTA внешнего сервера.

Ну вот мы и рассмотрели все возможные несовместимые комбинации потоковых
моделей клиентов и серверов. Мы увидели, как COM предоставляет
возможность этим клиентам и серверам работать совместно. Теперь я бы
хотел рассказать о необычайно интересном вопросе смешанного
использования потоковых моделей. С появлением STA и MTA иногда стала
появляться необходимость взаимодействия клиентов и серверов с потоками
STA в одних местах и с потоками MTA в других местах внутри одного
приложения. Обычно такая потребность появляется по бизнес-причинам,
появляющимся при тщательном изучении того, как Ваши клиентское и
серверное приложения будут взаимодействовать друг с другом. Например,
Ваш сервер может нуждаться в использовании некоторых объектов для
решения задач реального времени, в то время как другие не должны (или не
могут) работать в режиме \"производительности реального времени\". В
этом случае логично иметь объекты \"реального времени\", создаваемые в
MTA, где они могут реализовать максимальную производительность, и, в то
же время, иметь остальные объекты, обслуживаемые в одном или многих STA.
То, что я должен описать здесь, называется Смешанная потоковая модель
(Mixed Threading Model), обозначая тем самым, что Ваше приложение
пользуется комбинацией (смесью) различных потоковых моделей для своих
объектов.

В действительности в смешанной модели нет ничего нового. Клиентское
приложение может, например, создавать целый букет рабочих потоков,
живущих в MTA, в то время как другая группа потоков STA обслуживает
какие-то другие потребности.

Серверное приложение также может работать аналогично, т.е.
организовывать гроздь объектов в MTA для получения максимальной
производительности и, в то же время, порождать кучу потоков STA для
других объектов. Мне нет никакой необходимости демонстрировать, как
клиент или сервер собирается создавать STA и MTA в рамках единственного
процесса, так как Вы уже знакомы с технологией как это делается.
Необходимо только создать букет потоков, каждый из которых входит либо в
STA, либо в MTA и, бум!, Вы получили смешанную потоковую модель,
работающую в Вашем приложении. Об этой смешанной модели важно знать то,
что она существует и может оказаться очень удобной для решения каких-то
проблем, которые могут встретиться Вам при создании Вами клиентских и
серверных приложений. Поддержка смешанной потоковой модели для внешних
серверов заключается просто в создании букета потоков и явным указанием
для каждого потока его STA или MTA.

Для внутренних серверов, однако, мы можем ожидать, что COM полагается на
строковый параметр ThreadingModel, как и в случае однопотокового STA.
Сервером объектов может быть использован строковый параметр
\"ThreadingModel=Both\" для указания, что COM может свободно создавать
этот объект в STA или в MTA, т.е. он поддерживает как STA, так и MTA.

Но как COM узнает, должен он создавать объект в STA или в MTA? Как я уже
говорил ранее, внутренний сервер обычно рассчитывает, что клиентское
приложение явно создает потоки STA и MTA, содержащие серверные объекты.
В случае, когда \"ThreadingModel=Both\", подразделение клиентского
потока прямо определяет, где COM будет создавать этот объект. Другими
словами, если клиентский поток STA создает объект - COM явно создает его
в STA. Если клиентский поток MTA создает объект - COM однозначно создаст
его в MTA.