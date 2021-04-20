const supported = [
    'last 2 versions',
    '> 5% in PL'
];

module.exports = {
    plugins: [
        require('cssnano')({
            preset: ['default', {
                discardComments: {
                    removeAll: true,
                },
            }]
        }),
        require('autoprefixer')
    ]
}