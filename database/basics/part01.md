---
Title: 1. Что такое базы данных?
Date: 01.01.2007
Author: Vit
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Итак, базы данных существуют следующих видов:

1. **Древовидные** - простейший пример - Windows Registry, файловая система
FAT и XML - здесь информация хранится в древовидной структуре и доступ
осуществляется через "путь", т.е. указание всех узлов от корневого до
нужного. Например: "c:\\My Docs\\MyPictures\\Me.jpg". Недостатки этого
способа хранения данных является очень медленный поиск, если не известен
путь и очень плохая устойчивость к повреждениям структуры.
Преимущество - возможность хранить в классифицированном виде очень разнородную
информацию и очень быстрый поиск при знании ключа. Эти базы данных мы
разбирать здесь не будем.

2. **Сетевые базы данных** - простейший пример - интернет. Т.е. существуют
узлы, обособленные друг от друга, содержащие определённую информацию.
Каждый узел представляет какое-то количество ссылок на другие узлы, по
которым и ведётся поиск. Недостатки - очень сложный и долгий поиск,
возможна неполное предоставление информации или невозможность найти
нужную информацию. Преимущества - очень легко добавить любую,
разнородную информацию, самая высокая стабильность из всех систем. Эти
базы данных мы разбирать здесь не будем.

3. **Объектные базы данных** - новое веяние. Их мы разбирать здесь не будем,
но интересующиеся найдут интересной дискуссию о них в нашем разделе по
базам данных.

4. **Реляционные базы данных** - именно с ними мы и будем работать. В
дальнейшем если говорится "база данных", то подразумевается
"Реляционная база данных". "Реляционный" - Relation - обозначает
взаимосвязанный. С этими связями мы будем разбираться потом, а пока
можно для простоты считать, что реляционная база данных - это набор
двумерных простых таблиц. Недостатки реляционных баз данных - хранение
только однородной информации, сложности в добавлении новых структур и
взаимоотношений, информация хранящаяся в такой БД должна быть в нужной
степени абстрагированна. Преимущества - прежде всего очень высокая
скорость поиска - по этому параметру у реляционных баз данных
конкурентов нет, высокая стабильность, обилие софта для их поддержки и
разработки, удобность для очень широкого круга задач.

 
