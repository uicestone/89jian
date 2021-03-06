鲁班锁——一个易于扩展的企业资源管理工具
====

鲁班锁旨在简化企业的数据管理方式，提高非技术人员的工作效率。它由一个数据中心、一个通用的列表和一系列可扩展的数据展现模板组成，是以RESTFul风格编写的B-S SaaS应用。
前端采用Angular.js框架编写，支持IE8及以上、Chrome、Firefox和Safari等浏览器。后端采用Codeigniter框架编写，需要php5.5，MySQL5.5及以上环境。


#数据结构

##对象 (Object)
所有数据被抽象为独立的“对象”，它可以是一段时间（日程）、一笔钱（账目）、一个项目（事务）、一个人（人员或组）、一个文档（知识）或者其他。
每个对象有四类属性：元数据(meta)，状态(status)，标签(tag)和关联对象(relative)。

##元数据 (Meta)

描述对象的所有一般信息，如客户的电话，文档的类型，日程所耗费的时间等。这些信息在对象间一般不具有普遍重复性，对于具有普遍重复性的元数据，应当使用标签分类(Tag)来记录。

##状态 (Status)

描述一个对象的一个状态，以及进入这个状态的时间节点，如日程的开始时间，结束时间，账目的预计收款时间、实际到账时间，项目在工作流各节点时间。

##分类标签 (Tag)

描述对象的分类，是一组分类方式-分类值的对应，如案件的案源类型-个人案源，学生的生源类型-统招等。

##关联对象 (Relative)
描述对象与其他对象的关系。如人在项目中的参与状态，人与日程的已分配、已删除状态。
 - 每一个关系可以有自己的属性（元数据），如日程与人关系的状态，消息与人关系的已读等。
 - 当一个关系的属性特别复杂，或是需要记录关系的状态，关系的关联对象等信息时，应当将关系本身定义为一类对象。

##权限 (Permission)

#自定列表

用户默认将获得一个所有有权浏览的对象列表，并可通过条件筛选形成有生产意义的对象集。如：在职员工，成交客户，组织架构；待办事项，工作日志；进展中的项目；应收帐款，创收，费用；文档，知识等等
筛选后的列表可以为用户或用户组组保存，形成菜单。

#模版体系

对于任何一个列表，将可以对应一个特殊的模版来变换数据展现的方式。如以日历形式展现日程，以四象限展现待办事项，以进度图表来展现项目，以绩效展现职员，以关系图谱和质量评估表展现客户。
