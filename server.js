const express = require('express');
const bodyParser = require('body-parser');
const app = express();

app.use(bodyParser.json());

// Mock user database
const users = [
    {
        id: 1,
        email: 'staff@strathmore.edu',
        password: 'securepassword123', // In real app, store hashed passwords
       
    },
    {
        id: 2,
        email: 'student@strathmore.edu',
        password: 'studentpass123',
        
    }
];

// Login endpoint
app.post('config/studentlogin.php', (req, res) => {
    const { username, password } = req.body;

    // Validate Strathmore email
    if (!username.endsWith('@strathmore.edu')) {
        return res.status(400).json({
            success: false,
            message: 'Only Strathmore University emails are allowed (@strathmore.edu)'
        });
    }

    // Find user
    const user = users.find(u => u.email === username);
    
    if (!user) {
        return res.status(401).json({
            success: false,
            message: 'User not found'
        });
    }

    // Check password (in real app, use bcrypt to compare hashed passwords)
    if (user.password !== password) {
        return res.status(401).json({
            success: false,
            message: 'Invalid credentials'
        });
    }

    // Successful login (in real app, generate a proper JWT)
    res.json({
        success: true,
        token: 'mock-jwt-token-here',
        user: {
            id: user.id,
            email: user.email,
            role: user.role
        }
    });
});

// Protected route example
app.get('/api/protected', (req, res) => {
    const token = req.headers.authorization;
    
    if (!token) {
        return res.status(401).json({ message: 'Unauthorized' });
    }
    
    // In real app, verify JWT here
    res.json({ message: 'Protected data accessed successfully' });
});

const PORT = 3000;
app.listen(PORT, () => {
    console.log(`Server running on http://localhost:${PORT}`);
});