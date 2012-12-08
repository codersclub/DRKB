---
Title: Получить язык MS Word
Date: 01.01.2007
---


Получить язык MS Word
=====================

::: {.date}
01.01.2007
:::

How can I read the default language of installed MS Word application?

    // You may initialize Word.Application instance and read a CountryID: 
     
    var
       word: OLEVariant;
     begin
       word := CreateOLEObject('Word.Application');
       CountryID := word.System.Country;
       word.Quit;
       word := UnAssigned;
     end;
     
     // After that check this CountryID with next values: 
      wdUS = $00000001;
       wdCanada = $00000002;
       wdLatinAmerica = $00000003;
       wdNetherlands = $0000001F;
       wdFrance = $00000021;
       wdSpain = $00000022;
       wdItaly = $00000027;
       wdUK = $0000002C;
       wdDenmark = $0000002D;
       wdSweden = $0000002E;
       wdNorway = $0000002F;
       wdGermany = $00000031;
       wdPeru = $00000033;
       wdMexico = $00000034;
       wdArgentina = $00000036;
       wdBrazil = $00000037;
       wdChile = $00000038;
       wdVenezuela = $0000003A;
       wdJapan = $00000051;
       wdTaiwan = $00000376;
       wdChina = $00000056;
       wdKorea = $00000052;
       wdFinland = $00000166;
       wdIceland = $00000162;

Взято с сайта: <https://www.swissdelphicenter.ch>
