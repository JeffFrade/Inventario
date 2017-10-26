var vue = new Vue({
	el:"#app",

	data:{
		img:"",
		doc:"",
        txt: "",
        err: "",
        classe: "",
		msg: "",
        docu: '',
        list: [],
        images: ''
	},

    methods: {
        digitar: function () {
            if (this.txt === "-" || this.txt === "." || this.txt === "/" || this.txt === "\\" || this.txt === "|" || this.txt === " ") {
            	this.msg = 'Erro: ';
                this.err = 'Crie um Número de Série.';
                this.classe = 'alert alert-danger';
                console.log(this.err);
                console.log(this.classe);
                return this;
            }
            this.msg = "";
            this.err = "";
            this.classe = "";
            return this;
        },

        insere: function()
        {
            if (this.docu !== "") {
                this.list.push({ docu: this.docu });
                this.docu = '';
                this.retorna();
            }
        },

        retorna: function() {
            var ret = "";
            for (var i in this.list) {
                if (ret === "") {
                    ret = ret + this.list[i]['docu'];
                } else {
                    ret = ret + ";" + this.list[i]['docu'];
                }
            }

            this.images = ret;
        },

        remover: function(index) {
            this.list.splice(index, 1);
            this.retorna();
        }
    },

    ready: function() {
        if (this.images !== "") {
            var arr = this.images.split(";");
            for (var i in arr) {
                this.list.push({ docu:arr[i] });
            }
        }
    }
});