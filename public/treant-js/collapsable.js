/*
    var chart_config = {
        chart: {
            container: "#collapsable",

            animateOnInit: true,
            rootOrientation: "WEST",
            node: {
                collapsable: true
            },
            animation: {
                nodeAnimation: "easeOutBounce",
                nodeSpeed: 700,
                connectorsAnimation: "bounce",
                connectorsSpeed: 700
            }
        },
        nodeStructure: {
            image: "/images/uploads/4ee479e2c6995d33723eb5b27380f9fb.jpg",
            children: [
                {
                    image: "/images/uploads/4ee479e2c6995d33723eb5b27380f9fb.jpg",
                    collapsed: true,
                    children: [
                        {
                            image: "/images/uploads/4ee479e2c6995d33723eb5b27380f9fb.jpg"
                        }
                    ]
                },
                {
                    image: "/images/uploads/4ee479e2c6995d33723eb5b27380f9fb.jpg",
                    childrenDropLevel: 1,
                    children: [
                        {
                            image: "/images/uploads/4ee479e2c6995d33723eb5b27380f9fb.jpg"
                        }
                    ]
                },
                {
                    pseudo: true,
                    children: [
                        {
                            image: "/images/uploads/4ee479e2c6995d33723eb5b27380f9fb.jpg"
                        },
                        {
                            image: "/images/uploads/4ee479e2c6995d33723eb5b27380f9fb.jpg"
                        }
                    ]
                }
            ]
        }
    };
*/
    var config = {
        container: "#collapsable",

        animateOnInit: true,
        
        node: {
            collapsable: true
        },
        animation: {
            nodeAnimation: "easeOutBounce",
            nodeSpeed: 700,
            connectorsAnimation: "bounce",
            connectorsSpeed: 700
        }
    },
    malory = {
        image: "img/malory.png"
    },

    lana = {
        parent: malory,
        image: "img/lana.png"
    }

    figgs = {
        parent: lana,
        image: "img/figgs.png"
    }

    sterling = {
        parent: malory,
        childrenDropLevel: 1,
        image: "img/sterling.png"
    },

    woodhouse = {
        parent: sterling,
        image: "img/woodhouse.png"
    },

    pseudo = {
        parent: malory,
        pseudo: true
    },

    cheryl = {
        parent: pseudo,
        image: "img/cheryl.png"
    },

    pam = {
        parent: pseudo,
        image: "img/pam.png"
    },

    chart_config = [config, malory, lana, figgs, sterling, woodhouse, pseudo, pam, cheryl];
