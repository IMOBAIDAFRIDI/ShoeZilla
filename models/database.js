const Sequelize = require('sequelize');

const sequelize = new Sequelize({
    dialect: 'sqlite',
    storage: './shoezilla.sqlite',
    logging: false
});

module.exports = sequelize;
