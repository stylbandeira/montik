import axios from 'axios';
import { useEffect, useState } from 'react';

export default function Cupom({ cupomAplicado, setCupomAplicado }) {
    const [cupom, setCupom] = useState('');

    const handleCupom = async (e) => {
        e.preventDefault()
        try {
            const response = await axios.get('/api/cupons', {
                params: {
                    codigo: cupom
                }
            });

            localStorage.setItem('cupomAplicado', JSON.stringify(response.data.cupom));
            setCupomAplicado(response.data.cupom);
        } catch (error) {
            console.error(response.message)
            setCupomAplicado(null);
        }

        //INSERE NO CARRINHO O CUPOM
        //(DENTRO DO CÁLCULO DO COMPONENTE CARRINHO, SÃO ATUALIZADOS OS VALORES)

        // console.log(response.data);
    }

    useEffect(() => {
        const cupomGuardado = JSON.parse(localStorage.getItem('cupomAplicado'));

        setCupomAplicado(cupomGuardado);
        cupomGuardado ? setCupom(cupomGuardado.codigo) : setCupom('')
    }, []);

    return (
        <>
            <div className="m-2 w-100">
                <form className='w-100'>
                    <input
                        type="text"
                        className='w-100'
                        placeholder='Digite o Cupom'
                        onChange={(e) => setCupom(e.target.value)}
                        value={cupom}
                    />

                    <button
                        onClick={handleCupom}
                        className='w-100 btn btn-success mt-2'
                    >
                        Aplicar Cupom
                    </button>
                </form>
            </div>
        </>
    );
}
