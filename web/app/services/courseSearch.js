courseGrab.service('courseSearch', ['$http', function ($http) {

        var formFields = ['school', 'semester', 'year', 'location', 'instructor',
            'days', 'subject', 'subjectNumber', 'courseNumber', 'section', 'credits',
            'campus', 'startTime', 'endTime'
        ];

        this.initalizeCourseSearch = function() {
            var courseSearch = [];
            for (var i = 0; i < formFields.length; i++) {
                courseSearch[formFields[i]] = {
                    'name': 'Select a ' + formFields[i],
                    'value': null
                };
            }
            return courseSearch;
        };

    }]);
