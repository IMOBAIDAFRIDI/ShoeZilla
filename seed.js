const sequelize = require('./models/database');
const Product = require('./models/Product');
const User = require('./models/User');

const seedData = async () => {
    try {
        await sequelize.sync({ force: true });
        console.log('Database synced.');

        // Create Admin
        await User.create({
            username: 'Admin',
            email: 'admin@shoezilla.com',
            password: 'adminpassword',
            isAdmin: true
        });
        console.log('Admin user created (email: admin@shoezilla.com, pass: adminpassword).');

        // Create Products
        const products = [
            {
                name: 'Nike Air Max 270',
                description: 'The Nike Air Max 270 delivers unrivaled comfort.',
                price: 150.00,
                oldPrice: 180.00,
                imageUrl: 'https://static.nike.com/a/images/c_limit,w_592,f_auto/t_product_v1/05796a5f-b51f-495c-9c94-9635b706c836/air-max-270-mens-shoes-KkLcGR.png',
                category: 'Men',
                stock: 50,
                isFeatured: true
            },
            {
                name: 'Adidas Ultraboost',
                description: 'Experience the energy return of Boost.',
                price: 180.00,
                imageUrl: 'https://assets.adidas.com/images/w_600,f_auto,q_auto/1a5b481921474dd88806af5200d72f9d_9366/Ultraboost_Light_Shoes_White_HQ6351_01_standard.jpg',
                category: 'Men',
                stock: 30,
                isFeatured: true
            },
            {
                name: 'Puma Running Shoes',
                description: 'Lightweight and durable running shoes.',
                price: 90.00,
                imageUrl: 'https://images.puma.com/image/upload/f_auto,q_auto,b_rgb:fafafa,w_2000,h_2000/global/195337/01/sv01/fnd/IND/fmt/png/Velocity-NITRO-2-Men',
                category: 'Joggers',
                stock: 100,
                isFeatured: true
            },
            {
                name: 'Nike Air Force 1',
                description: 'Classic style, modern comfort.',
                price: 100.00,
                imageUrl: 'https://static.nike.com/a/images/t_PDP_1280_v1/f_auto,q_auto:eco/b7d9211c-26e7-431a-ac24-b0540fb3c00f/air-force-1-07-mens-shoes-jBrhbr.png',
                category: 'Women',
                stock: 45,
                isFeatured: true
            }
        ];

        await Product.bulkCreate(products);
        console.log('Products seeded.');

        process.exit();
    } catch (err) {
        console.error('Seeding failed:', err);
        process.exit(1);
    }
};

seedData();
