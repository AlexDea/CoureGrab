
@set /p entityPath= Enter entity's name: 
php app/console doctrine:generate:entities Devblock/CourseGrabBundle/Entity/%entityPath%
@PAUSE