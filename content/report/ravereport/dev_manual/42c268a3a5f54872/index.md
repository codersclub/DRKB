---
Title: Введение в Rave
Date: 01.01.2007
---


Введение в Rave
===============

::: {.date}
01.01.2007
:::

Панель компонент Rave

Имеются два типа объектов в Rave, компоненты вывода (Output Components)
и классы отчета (Report Classes). Компоненты вывода отвечают за вывод
отчета на различные устройства вывода, а классы отчета, которые не
являются компонентными классами, отвечают за все остальные задачи.

![](/pic/embim1741.png){width="56" height="55"}        TrvSystem      
 Включает в себя стандартный принтер и предварительный просмотр и
является одним из самых простых в использовании компонент.        

![](/pic/embim1742.png){width="56" height="55"}        TRvNDRWriter    
   Создает NDR поток или файл (в должном формате) при выполнении отчета.
       

![](/pic/embim1743.png){width="56" height="55"}        TrvRenderPreview
       Показывает диалог предварительного просмотра для NDR потока или
файла.        

![](/pic/embim1744.png){width="56" height="55"}        TrvRenderPrinter
       Посылает NDR поток или файл на принтер.        

![](/pic/embim1745.png){width="56" height="55"}        TRvRenderPDF    
   Преобразовывает NDR поток или файл в PDF формат.        

![](/pic/embim1746.png){width="56" height="55"}        TRvRenderHTML    
   Преобразовывает NDR поток или файл в HTML формат.        

![](/pic/embim1747.png){width="56" height="55"}        TRvRenderRTF    
   Преобразовывает NDR поток или файл в RTF формат.        

![](/pic/embim1748.png){width="56" height="55"}        TRvRenderText    
   Преобразовывает NDR поток или файл в Text формат.        

Классы Rave

![](/pic/embim1749.png){width="56" height="55"}        TrvProject      
 Производит соединение к проекту отчета, который был создан с помощью
визуального редактора Rave. Используйте данный компонент для получения
списка всех доступных отчетов или для выполнения конкретного отчета.    
   

![](/pic/embim1750.png){width="56" height="55"}      
 TrvCustomConnection        Подсоединяет пользовательские данные
(сгенерированные через события) к DirectDataViews, созданные с помощью
визуального редактора Rave.        

![](/pic/embim1751.png){width="56" height="55"}      
 TrvDataSetConnection        Подсоединяет TDataSet данные (например,
TClientDataSet, или компоненты третьих сторон, наследники  от TDataSet)
к DirectDataViews, созданные с помощью визуального редактора Rave.      
 

![](/pic/embim1752.png){width="56" height="55"}      
 TrvTableConnection        Подсоединяет TTable компоненты к
DirectDataViews, созданные с помощью визуального редактора Rave.        

![](/pic/embim1753.png){width="56" height="55"}      
 TrvQueryConnection        Подсоединяет TQuery компоненты к
DirectDataViews, созданные с помощью визуального редактора Rave.        