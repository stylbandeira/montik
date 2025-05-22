import ApplicationLogo from '@/Components/ApplicationLogo';
import Header from '@/Components/Header';
import { Link, Head, usePage } from '@inertiajs/react';

export default function Produtos() {
    const { produtos } = usePage().props;
    return (
        <>
            <Head title="Montink" />
            <Header></Header>
            <div className='text-primary'>
                <h1>Lista de Produtos</h1>

                <ul>
                    {produtos.map(produto => (
                        <li key={produto.id}>{produto.nome}</li>
                    ))}
                </ul>
            </div>
        </>
    );
}
