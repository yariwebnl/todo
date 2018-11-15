    var app1 = new Vue ({
        el: '#app1',
        data: {
            message: 'To-do list',
        }
    })

    var app2 = new Vue ({
        el: '#app2',
        data: {
            message: 'Vue & Laravel',
        }
    })

    var app3 = new Vue ({
        el: '#app3',
        data: {
            todos: [

            ]
        },
        methods: {
            add: function(){
                var task = document.getElementById('addtask').value;
                if (task.length > 0){
                    app3.todos.push({ text: task, done: false });
                }
            },
            del: function(index){
                this.todos.splice(index, 1);
            }
        }
    })