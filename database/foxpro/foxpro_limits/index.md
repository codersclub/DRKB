---
Title: Ограничения Foxpro
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Ограничения Foxpro
==================

**Table and Index Files**

Parameter | Value
--------- | -----
Max. # of records per table | 1 billion [*]
Max. # of chars per record | 65,000
Max. # of fields per record | 255
Max. # of open DBFs |  225
Max. # of chars per field | 254
Max. # of chars per index key (IDX) | 100
Max. # of chars per index key (CDX) | 240
Max. # of open index files per table | unlimited [**]
Max. # of open index files in all work areas | unlimited [**]

**Field Characteristics**

Parameter | Value
--------- | -----
Max. size of character fields | 254
Max. size of numeric fields |  20
Max. # of chars in field names | 10
Digits of precision in numeric computations | 16

[*] The actual file size (in bytes) cannot exceed 2 gigabytes for
single-user or exclusively opened multi-user tables. Shared tables with
no indexes or .IDX indexes cannot exceed 1 gigabyte. Shared tables with
structural .CDX indexes cannot exceed 2 gigabytes.

[**] Limited by memory. In FoxPro for MS-DOS and FoxPro for Windows,
also limited by available MS-DOS file handles. Each .CDX file uses only
1 file handle. The number of MS-DOS file handles is determined by the
CONFIG.SYS FILES parameter.

